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
        $travel = Travel::find($checkTicket->travel_id);

        //$travel->unSetRelation('company');
        $travel->unsetRelation('tickets');
        $travel->unSetRelation('busType');
      $checker = request()->user();

      if($checker->type == 'checker')
      {
          if($checkTicket->status)
          {
              $ticket->travel = $travel;
              return response(['used',$ticket],410);
          }
          else {
              //return "here";
              $order = Order::find($ticket->order_id);
              $payment = Payment::find($order->payment_id);
              if($payment->status == 'accepted')
              {

                  $checkTicket->status = true;
                  $checkTicket->travel = $travel;
                  $ticket->save();
                  $scannedTicket = new ScannedTicket();
                  $scannedTicket->checker_id = $checker->id;
                  $scannedTicket->ticket_id = $ticket->id;
                return response(['welcome to our bus',$ticket],200);
            }
          }
      }
      else{

          return response('An Authorized',401);
      }

    }
}
