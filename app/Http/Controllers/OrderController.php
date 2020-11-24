<?php

namespace App\Http\Controllers;

use App\Models\BusType;
use App\Models\City;
use App\Models\Company;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Seat;
use App\Models\Ticket;
use App\Models\Travel;
use App\Models\User;
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
                $travel= null ;
                $busType= null;
                $busCompany=null;
                foreach($tickets as $ticket){
                    $seats = Seat::where('ticket_id', $ticket->id)->get();

                    $travel = Travel::find( $ticket->travel_id);

                    $busType = BusType::find( $travel->busType_id);

                    $busCompany = Company::find($travel->company_id);
                    $ticket->seats = $seats;


                    $ticket->unSetRelation('order');
                    array_push($ticketsResponse , $ticket);
                }
                $order->travel = $travel;
                $order->busType = $busType;
                $order->busCompany = $busCompany;
                $order->tickets = $ticketsResponse;
                array_push($orderResonse, $order);
            }
            return response()->json(["orders"=>$orderResonse], 200);
        }
        else if ($data['status'] == 'pending'){

            $orderResonse = [];
            $pendingOrders =[];
            $orders = Order::where('user_id',$user)->get();

            foreach($orders as $order){
                if($order->payment_id != null){
                    $payment = Payment::find($order->payment_id);

                    if($payment->status == "pending"){
                        array_push($pendingOrders , $order);
                    }
                }

            }


            foreach($pendingOrders as $order){
                $tickets = Ticket::where('order_id', $order->id)->get();
                $ticketsResponse =[];
                $travel =null;
                $busType = null;
                $busCompany = null;
                foreach($tickets as $ticket){
                    $seats = Seat::where('ticket_id', $ticket->id)->get();

                    $travel = Travel::find( $ticket->travel_id);

                    $busType = BusType::find( $travel->busType_id);

                    $busCompany = Company::find( $travel->company_id);
                    $ticket->seats = $seats;
                    $ticket->unSetRelation('order');
                    array_push($ticketsResponse , $ticket);
                }
                $order->travel = $travel;
                $order->busType = $busType;
                $order->busCompany = $busCompany;
                $order->tickets = $ticketsResponse;
                array_push($orderResonse, $order);
            }
            return response()->json(["orders"=>$orderResonse], 200);
        }else if ($data['status'] == 'declined'){
            $orderResonse = [];
            $pendingOrders =[];
            $orders = Order::where('user_id',$user)->get();

            foreach($orders as $order){
                if($order->payment_id != null){
                    $payment = Payment::find($order->payment_id);
                    if($payment->status == "rejected"){
                        array_push($pendingOrders , $order);
                    }
                }
            }


            foreach($pendingOrders as $order){
                $tickets = Ticket::where('order_id', $order->id)->get();
                $ticketsResponse =[];
                $travel = null;
                $busCompany=null;
                $busType=null;
                foreach($tickets as $ticket){
                    $seats = Seat::where('ticket_id', $ticket->id)->get();

                    $travel = Travel::find( $ticket->travel_id);

                    $busType = BusType::find( $travel->busType_id);

                    $busCompany = Company::find( $travel->company_id);
                    $ticket->seats = $seats;
                    $ticket->unSetRelation('order');
                    array_push($ticketsResponse , $ticket);
                }
                $order->travel = $travel;
                $order->busType = $busType;
                $order->busCompany = $busCompany;
                $order->tickets = $ticketsResponse;
                array_push($orderResonse, $order);
            }
            return response()->json(["orders"=>$orderResonse], 200);
        }
        else if ($data['status'] == 'success'){
            $orderResonse = [];
            $pendingOrders =[];
            $orders = Order::where('user_id',$user)->get();

            foreach($orders as $order){
                if($order->payment_id != null){
                    $payment = Payment::find($order->payment_id);
                    if($payment->status == "accepted"){
                        array_push($pendingOrders , $order);
                    }
                }
            }


            foreach($pendingOrders as $order){
                $tickets = Ticket::where('order_id', $order->id)->get();
                $ticketsResponse =[];
                $busType=null;
                $busCompany = null;
                $travel = null;
                foreach($tickets as $ticket){
                    $seats = Seat::where('ticket_id', $ticket->id)->get();

                    $travel = Travel::find( $ticket->travel_id);

                    $busType = BusType::find( $travel->busType_id);

                    $busCompany = Company::find( $travel->company_id);
                    $ticket->seats = $seats;
                    $ticket->unSetRelation('order');
                    array_push($ticketsResponse , $ticket);
                }
                $order->travel = $travel;
                $order->busType = $busType;
                $order->busCompany = $busCompany;
                $order->tickets = $ticketsResponse;
                array_push($orderResonse, $order);
            }
            return response()->json(["orders"=>$orderResonse], 200);
        }else{
           return response()->json(["message"=>"invalid status request sent"],500);
        }


    }


    public function index()
    {
       $superAdmin = request()->user();
       if($superAdmin->type == 'booking_company')
       {
           $orders = Order::all();

           foreach ($orders as $order)
           {


               $userName = User::find($order->user_id)->full_name;

               $paymentCheck = Payment::find($order->payment_id);
               if($paymentCheck)
                $payment = $paymentCheck->status;
               else
                   $payment = "not paid";
               $numberOfTicket = Ticket::where('order_id',$order->id)->count();
               $order->name =$userName;
               $order->paymentStatus =$payment;
               $order->numberOfTicket =$numberOfTicket;
           }
           return $orders;
       }
       elseif ($superAdmin->type == 'company')
       {
           $orders = Order::where('company_id',$superAdmin->company_id)->get();
           foreach ($orders as $order)
           {


               $userName = User::find($order->user_id)->full_name;

               $paymentCheck = Payment::find($order->payment_id);
               if($paymentCheck)
                   $payment = $paymentCheck->status;
               else
                   $payment = "not paid";
               $numberOfTicket = Ticket::where('order_id',$order->id)->count();
               $order->name =$userName;
               $order->paymentStatus =$payment;
               $order->numberOfTicket =$numberOfTicket;
           }
           return $orders;
       }

       else{
           return response(['an Authorized user'],401);
       }



    }

}
