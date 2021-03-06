<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\BusType;
use App\Models\City;
use App\Models\Company;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Seat;
use App\Models\Ticket;
use App\Models\Travel;
use Illuminate\Http\Request;

class TravelController extends Controller
{

    public function index()
    {

        $user = request()->user();

        if ($user->type == 'booking_company') {


            $travels = Travel::all();

            return $travels;
        } else if ($user->type == 'company') {


            $travel = Travel::where('company_id', $user->company_id)->get();

            return $travel;
        } else {

            return response('An authorized user', 401);
        }
    }

    public function adminIndex(Request $request)
    {

        $user = $request->user();

        if ($user->type == 'booking_company') {


            $travels = Travel::orderBy('created_at', 'desc');

            if ($request->has('company') && $request->company != 'all') {
                $travels = $travels->where('company_id', $request->company);
            }

            if ($request->has('from') && $request->from != 'all') {
                $travels = $travels->where('startCityId', $request->from);
            }

            if ($request->has('to') && $request->to != 'all') {
                $travels = $travels->where('dropOfCityId', $request->to);
            }

            if ($request->has('date') && $request->date) {
                $travels = $travels->where('local', $request->date);
            }

            $travels = $travels->paginate(10)->withQueryString();

            return $travels;
        } else if ($user->type == 'company') {
            $travels = Travel::orderBy('created_at', 'desc')->where('company_id', $user->company_id);

            if ($request->has('from') && $request->from != 'all') {
                $travels = $travels->where('startCityId', $request->from);
            }

            if ($request->has('to') && $request->to != 'all') {
                $travels = $travels->where('dropOfCityId', $request->to);
            }

            if ($request->has('date') && $request->date) {
                $travels = $travels->where('local', $request->date);
            }

            $travels = $travels->paginate(10)->withQueryString();

            return $travels;
        } else {

            return response('An authorized user', 401);
        }
    }


    public function availableTravel(Request $request)
    {
        $data = $request->validate([
            'fromId' => 'required',
            'toId' => 'required',
            'date' => 'required',
            'type' => 'required'
        ]);

        $travels = [];

        $vehicleType = $request->type;

        $busType = BusType::where("vehicle_type", $vehicleType)->get();

        foreach ($busType as $bust) {
            $listOfTravels = Travel::where("busType_id", $bust->id)->where('startCityID', $data['fromId'])
                ->where('dropOfCityID', $data['toId'])
                ->where('local', $data['date'])->get();
            foreach ($listOfTravels as $travel) {
                $start_city = City::find($travel->startCityId);
                $drop_of_city = City::find($travel->dropOfCityId);

                $travel->start_city = $start_city;
                $travel->drop_of_city = $drop_of_city;


                $numberOfReservedSeats = 0;
                $tickets = $travel->tickets;

                foreach ($tickets as $ticket) {
                    $seats = $ticket->seats;
                    //return $seats;
                    $reservedSeat = $seats->where('status', 'reserved')->count();
                    $booked = $seats->where('status', 'booked')->count();

                    $numberOfSeats = $reservedSeat + $booked;

                    $numberOfReservedSeats = $numberOfReservedSeats + $numberOfSeats;
                }

                $busId = BusType::where('id', $travel->busType_id)->first();
                //$busId gives the busType
                $availableSeats = $busId->capacity - $numberOfReservedSeats;

                $travel->numberOfavilableSeats = $availableSeats;
                $travel->companyName = $travel->company->name;
                $travel->busName = $travel->busType->name;
                $travel->unSetRelation('company');
                $travel->unsetRelation('tickets');
                $travel->unSetRelation('busType');
                if ($availableSeats > 0) {
                    array_push($travels, $travel);
                }
            }
        }



        return $travels;
    }

    public function reservedSeats(Travel $travel)
    {
        $tickets = $travel->tickets;
        $seats = [];

        foreach ($tickets as $ticket) {
            array_push($seats, $ticket->seats->first());
        }

        $temp = [];

        $busType = BusType::find($travel->busType_id);
        $busType->side_number = $travel->side_number;
        $company = Company::find($travel->company_id);

        return response()->json(["seats" => $seats, "busType" => $busType, "company" => $company]);
    }


    public function bookTravel(Request $request)
    {
        $data = $request->validate([

            'travel_id' => 'exists:travel,id',
            'seats' => ["required", "array", "min:1"],
        ]);

        $seats = $data['seats'];

        if (auth()->check()) {
            $reserveSeat = new Seat();
            for ($i = 0; $i < sizeof($seats); $i++) {

                $checker = Seat::where('seatNumber', $seats[$i])
                    ->where('travel_id', $data['travel_id'])
                    ->first();
                $busId = Travel::find($data['travel_id']);
                $capacity = BusType::find($busId->busType_id)->capacity;

                if ($checker) {

                    return response()->json(["message" => "seat have been taken"], 409);
                }
                if ($seats[$i] < $capacity) {
                    $ticket = new Ticket();
                    $ticket->user_id = auth()->user()->id;
                    $ticket->travel_id = $data['travel_id'];
                    $ticket->save();

                    $ticket->seats()->create([
                        'seatNumber' => $seats[$i],
                        'ticket_id' => $ticket->id,
                        'status' => 'reserved',
                        'travel_id' => $data['travel_id']
                    ]);
                    $ticket->save();
                }
                if ($seats[$i] > $capacity) {
                    return "wrong data";
                }
            }
        }
        return response()->json(["status" => "successful"], 200);
    }


    public function order(Request $request)
    {
        $data = $request->validate([

            'travel_id' => 'exists:travel,id',
            'seats' => ["required", "array", "min:1"]
        ]);

        $seats = $data['seats'];
        if (auth()->check()) {
            //$reserveSeat = new Seat();
            $price = Travel::find($data['travel_id']);
            $order = new Order();
            $order->user_id = auth()->user()->id;
            $order->total_price = $price->price * count($seats);
            $order->company_id = $price->company_id;
            $order->save();
            for ($i = 0; $i < sizeof($seats); $i++) {
                $checker = Seat::where('seatNumber', $data['seats'][$i]['seat'])->first();
                if ($checker) {
                    $ticketOrder = Ticket::find($checker->id);

                    $price = Travel::find($ticketOrder->travel_id)->price;


                    $ticketOrder->order_id = $order->id;
                    if (isset($data['seats'][$i]['name']))
                        $ticketOrder->for_name = $data['seats'][$i]['name'];
                    if (isset($data['seats'][$i]['phone']))
                        $ticketOrder->for_phone_no = $data['seats'][$i]['phone'];
                    $ticketOrder->save();
                } else {
                    return "wrong data insertion";
                }
            }
        }
        return response()->json(["status" => "seat ordered"], 200);
    }


    public function create(Request $request)
    {
        $data = $request->validate([
            'startCityId' => 'required',
            'dropOfCityId' => 'required',
            'busType_id' => 'required',
            'company_id' => 'required',
            'side_number' => 'required',
            'price' => 'required',
            'travel_km' => 'required',
            'travel_minutes' => 'required',
            'travel_pickup_time' => ['required', 'date_format:h:i:A'],
            'Gregorian' => ['required', 'date'],
            'local' => ['required', 'date']
        ]);
        $create = Travel::create($data);

        return $create;
    }


    public function show(Travel $travel)
    {
        $travel->unsetRelation('tickets');
        return response()->json($travel);
    }

    public function showAdmin(Travel $travel)
    {

        return response()->json($travel);
    }
}
