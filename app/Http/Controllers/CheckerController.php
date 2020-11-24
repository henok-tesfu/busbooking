<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Ticket;
use Illuminate\Http\Request;

class CheckerController extends Controller
{
    public function validateTicket(Ticket $ticket)
    {
        $checkTicket = $ticket;
        $checkTicket->unSetRelation('seats');
        $checkTicket->unSetRelation('order');
        if($checkTicket->status)
        {
           return response('used',410);
        }
        else {
            //return "here";
            $order = Order::find($ticket->order_id);
            $payment = Payment::find($order->payment_id);
            if($payment->status == 'accepted')
            {

                $checkTicket->status = true;
                $ticket->save();
                return response(['welcome to our bus'],200);
            }
        }
    }
}
