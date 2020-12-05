<?php

namespace App\Http\Controllers;

use App\Models\BusType;
use App\Models\City;
use App\Models\Travel;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isNull;

class CityTransportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {


           $busType = $request->validate([
               'type'=>"required"
           ]);
        $cities = [];


        $travelFrom = [];
        $vehicles = BusType::where('vehicle_type',$busType)->get();

        foreach ($vehicles as $vehicle)
        {
            $travel = Travel::where('busType_id',$vehicle->id)
                ->pluck('startCityId');



            array_push($travelFrom,$travel);


        }

        foreach ($travelFrom as $travel)
        {
            if($this->dataExists($cities ,City::find($travel))){

            }
            else{
                array_push($cities,City::find($travel));
            }

            //array_push($cities,City::find($travel));
        }

        return $cities;


    }
    public function dataExists($cities , $travel)
    {
        return in_array( $travel,$cities);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function show(City $city)
    {
        return "here";
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function travelFrom($busType,City $city)
    {

        //return $city;
        $cities = [];

        $travelFrom = [];
        $vehicles = BusType::where('vehicle_type',$busType)->get();
        // return $vehicles;
        foreach ($vehicles as $vehicle)
        {
            $travel = Travel::where('startCityId',$city->id)
                ->where('busType_id',$vehicle->id)->first();
            if ($travel) {


                $travel->unSetRelation('tickets');
                $travel->unSetRelation('startCity');
                $travel->unSetRelation('dropOfCity');
                $travel->unSetRelation('busType');
                $travel->unSetRelation('company');


                array_push($travelFrom, $travel->dropOfCityId);

            }

        }




        foreach ($travelFrom as $travel)
        {
            if($this->dataExists($cities ,City::find($travel))){

            }
            else{
                array_push($cities,City::find($travel));
            }

            //array_push($cities,City::find($travel));
        }

        return $cities;


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
