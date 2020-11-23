<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Ticket;
use Illuminate\Http\Request;

class CheckerController extends Controller
{
    public function validateTicket(Ticket $id)
    {
        $ticket = Ticket::find($id);
        if($ticket->status == 'used')
        {
           return "used ticket";
        }
        else {
            $order = Order::find($ticket->order_id);
            $payment = Payment::find($order->payment_id);
            if($payment->status == 'accepted')
            {
                $ticket->status = "used";
                $ticket->save();
                return response(['welcome to our bus'],200);
            }
        }
    }
}
