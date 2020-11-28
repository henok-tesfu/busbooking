<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\ScannedTicket;
use App\Models\Ticket;
use App\Models\Travel;
use Illuminate\Http\Request;

class CheckerController extends Controller
{
    public function validateTicket(Ticket $ticket)
    {

        $checkTicket = $ticket;
        //$checkTicket->unSetRelation('seats');
        $checkTicket->unSetRelation('order');
        $travel = Travel::findOrFail($checkTicket->travel_id);


        //$travel->unSetRelation('company');
        $travel->unsetRelation('tickets');
        $travel->unSetRelation('busType');
      $checker = request()->user();

      if($checker->type == 'company')
      {
          if($checkTicket->status)
          {
              $ticket->travel = $travel;
              return response(['used',$ticket],410);

          }
          else {

              $order = Order::findorFail($ticket->order_id);

              $payment = Payment::findorFail($order->payment_id);

              if(!$payment)
              {
                  return response('dose not existing');
              }

              if($payment->status == 'accepted')
              {

                  $checkTicket->status = true;
                  $ticket->save();
                  $checkTicket->travel = $travel;

                  $scannedTicket = new ScannedTicket();
                  $scannedTicket->checker_id = $checker->id;
                  $scannedTicket->ticket_id = $ticket->id;
                  $scannedTicket->save();
                return response(['welcome to our bus',$ticket],200);
            }
          }
      }
      else{

          return response('An Authorized',401);
      }

    }
}
