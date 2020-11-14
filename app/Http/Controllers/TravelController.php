<?php

namespace App\Http\Controllers;

use App\Models\BusType;
use App\Models\Company;
use App\Models\Seat;
use App\Models\Ticket;
use App\Models\Travel;
use Illuminate\Http\Request;

class TravelController extends Controller
{
    public function availableTravel(Request $request)
    {
        $data = $request->validate([
           'fromId'=>'required',
            'toId'=>'required',
           // 'dateType'=>'required',
            'date'=>'required'
        ]);


        $travels =[];


                $travels = Travel::where('startCityID',1)
                    ->where('dropOfCityID',$data['toId'])
                    ->where('local',$data['date'])->get();

               //return $travels->first()->tickets;

        //All the travels $travels with d/f busType

        $seatConcated = [];

        foreach ($travels as $travel){

            $numberOfReservedSeats =0;
          $tickets = $travel->tickets;

          foreach ($tickets as $ticket){
             $seats = $ticket->seats;
             //return $seats;
              $reservedSeat = $seats->where('status','reserved')->count();
              $booked = $seats->where('status','booked')->count();

             $numberOfSeats = $reservedSeat + $booked;

             $numberOfReservedSeats= $numberOfReservedSeats + $numberOfSeats;



          }

            $busId = BusType::where('id',$travel->busType_id)->first();
          //$busId gives the busType
            $availableSeats = $busId->capacity - $numberOfReservedSeats;

          $travel->numberOfavilableSeats = $availableSeats;
          $travel->companyName = $travel->company->name;
            $travel->busName = $travel->busType->name;
          $travel->unSetRelation('company');
          $travel->unsetRelation('tickets');
            $travel->unSetRelation('busType');
            if($availableSeats > 0)
            {
              array_push($seatConcated, $travel);

            }
        }

          return $seatConcated;

    }
    public function reservedSeats(Travel $travel)
    {
        $tickets = $travel->tickets;
        $seats = [];

        foreach ($tickets as $ticket)
        {
            array_push($seats, $ticket->seats->first());

        }

        $temp = [];

     $busType = BusType::find($travel->busType_id);
       $busType->side_number = $travel->side_number;
       $company = Company::find($travel->company_id);

        return response()->json(["seats"=>$seats , "busType"=>$busType ,"company"=>$company]);


    }


    public function bookTravel(Request $request)
    {
          $data =$request->validate([

          'travel_id'=>'exists:travel,id',
            'seats'=> ["required","array","min:1"]
          ]);

          $seats = $data['seats'];

          if(auth()->check())
          {
              $reserveSeat = new Seat();
              for($i=0;$i<sizeof($seats);$i++)
              {
                  $ticket = new Ticket();
                  $ticket->user_id = auth()->user()->id;
                  $ticket->travel_id =$data['travel_id'];
                  $ticket->save();
                  $ticket->seats()->create([
                      'seatNumber' =>$seats[$i],
                      'ticket_id'=>$ticket->id,
                        'status'=>'reserved'
                  ]);
                  $ticket->save();
              }
          }
          return response("successfully",200);
    }
}
