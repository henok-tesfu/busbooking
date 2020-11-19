<?php

namespace App\Http\Controllers;

use App\Models\BusType;
use App\Models\Company;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Seat;
use App\Models\Ticket;
use App\Models\Travel;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Foreach_;

class OrderController extends Controller
{
    public function orderedList(Request $request)
    {
        $user = auth()->user()->id;

        $data = $request->validate([
            'status'=>'required'
        ]);

        if ($data['status'] == 'ordered'){
            $orderResonse = [];
            $orders = Order::where('user_id',$user)->where('payment_id' , null)->get();
            foreach($orders as $order){
                $tickets = Ticket::where('order_id', $order->id)->get();
                $ticketsResponse =[];
                foreach($tickets as $ticket){
                    $seats = Seat::where('ticket_id', $ticket->id)->lists('seatNumber')->toArray();
                    $travel = Travel::where('id', $ticket->travel_id)->get();
                    $busType = BusType::where('busType_id', $$travel->busType_id)->get();
                    $busCompany = Company::where('id', $travel->company_id)->get();
                    $ticket->seats = $seats;
                    $ticket->treavel = $travel;
                    $ticket->busType = $busType;
                    $ticket->busCompany = $busCompany;
                    array_push($ticketsResponse , $ticket);
                }
                $order->tickets = $ticketsResponse;
                array_push($orderResonse, $order);
            }
            return response()->json(["orders"=>$orderResonse], 200);
        }
        else if ($data['status'] == 'pending'){
            $orderResonse = [];
            $pendingOrders =[];
            $orders = Order::where('user_id',$user)->where('payment_id' , null)->get();

            foreach($orders as $order){
                if($order->payment_id != null){
                    $payment = Payment::find($order->payment_id)->get();
                    if($payment->status == "pending"){
                        array_push($pendingOrders , $order);
                    }
                }
            }


            foreach($pendingOrders as $order){
                $tickets = Ticket::where('order_id', $order->id)->get();
                $ticketsResponse =[];
                foreach($tickets as $ticket){
                    $seats = Seat::where('ticket_id', $ticket->id)->lists('seatNumber')->toArray();
                    $travel = Travel::where('id', $ticket->travel_id)->get();
                    $busType = BusType::where('busType_id', $$travel->busType_id)->get();
                    $busCompany = Company::where('id', $travel->company_id)->get();
                    $ticket->seats = $seats;
                    $ticket->treavel = $travel;
                    $ticket->busType = $busType;
                    $ticket->busCompany = $busCompany;
                    array_push($ticketsResponse , $ticket);
                }
                $order->tickets = $ticketsResponse;
                array_push($orderResonse, $order);
            }
            return response()->json(["orders"=>$orderResonse], 200);
        }else if ($data['status'] == 'declined'){
            $orderResonse = [];
            $pendingOrders =[];
            $orders = Order::where('user_id',$user)->where('payment_id' , null)->get();

            foreach($orders as $order){
                if($order->payment_id != null){
                    $payment = Payment::find($order->payment_id)->get();
                    if($payment->status == "rejected"){
                        array_push($pendingOrders , $order);
                    }
                }
            }


            foreach($pendingOrders as $order){
                $tickets = Ticket::where('order_id', $order->id)->get();
                $ticketsResponse =[];
                foreach($tickets as $ticket){
                    $seats = Seat::where('ticket_id', $ticket->id)->lists('seatNumber')->toArray();
                    $travel = Travel::where('id', $ticket->travel_id)->get();
                    $busType = BusType::where('busType_id', $$travel->busType_id)->get();
                    $busCompany = Company::where('id', $travel->company_id)->get();
                    $ticket->seats = $seats;
                    $ticket->treavel = $travel;
                    $ticket->busType = $busType;
                    $ticket->busCompany = $busCompany;
                    array_push($ticketsResponse , $ticket);
                }
                $order->tickets = $ticketsResponse;
                array_push($orderResonse, $order);
            }
            return response()->json(["orders"=>$orderResonse], 200);
        }
        else if ($data['status'] == 'succecced'){
            $orderResonse = [];
            $pendingOrders =[];
            $orders = Order::where('user_id',$user)->where('payment_id' , null)->get();

            foreach($orders as $order){
                if($order->payment_id != null){
                    $payment = Payment::find($order->payment_id)->get();
                    if($payment->status == "accepted"){
                        array_push($pendingOrders , $order);
                    }
                }
            }


            foreach($pendingOrders as $order){
                $tickets = Ticket::where('order_id', $order->id)->get();
                $ticketsResponse =[];
                foreach($tickets as $ticket){
                    $seats = Seat::where('ticket_id', $ticket->id)->lists('seatNumber')->toArray();
                    $travel = Travel::where('id', $ticket->travel_id)->get();
                    $busType = BusType::where('busType_id', $$travel->busType_id)->get();
                    $busCompany = Company::where('id', $travel->company_id)->get();
                    $ticket->seats = $seats;
                    $ticket->treavel = $travel;
                    $ticket->busType = $busType;
                    $ticket->busCompany = $busCompany;
                    array_push($ticketsResponse , $ticket);
                }
                $order->tickets = $ticketsResponse;
                array_push($orderResonse, $order);
            }
            return response()->json(["orders"=>$orderResonse], 200);
        }else{
            response()->json(["message"=>"invalid status request sent"],500);
        }


    }
}
