<?php

namespace App\Http\Controllers;

use App\Models\ScannedTicket;
use App\Models\Ticket;
use App\Models\Travel;
use Illuminate\Http\Request;

class ScannedTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $cheker = request()->user();
        $scannedTickets = ScannedTicket::where('checker_id',$cheker->id)->get();

        $tickets = [];
        foreach ($scannedTickets as $scanned)
        {

            $ticket = Ticket::find($scanned->ticket_id);
             $travel = Travel::find($ticket->travel_id);
             $ticket->startCity =$travel->startCity;
            $ticket->dropOfCity =$travel->dropOfCity;
            $ticket->company = $travel->company;

            array_push($tickets,$ticket);


        }

        return $tickets;
    }


}
