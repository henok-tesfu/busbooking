<?php

namespace App\Http\Controllers;

use App\Models\BusType;
use App\Models\City;
use App\Models\Travel;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index()
    {
        $citys = City::all();
        return response($citys);
    }


    public function adminIndex(Request $request)
    {
        $citys = City::orderBy('created_at', 'desc')->paginate(($request->has('per_page') && $request->per_page) ? $request->per_page : 10);
        return response($citys);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required'
        ]);

        $city = City::create($data);

        return $city;
    }

    public function update(Request $request, City $city)
    {
        $data = $request->validate([
            'name' => 'required'
        ]);

        $response = City::where('id', $city->id) ->update($data);

        return $response;
    }

    public function travelFrom(City $city)
    {

        //return $city;
        $cities = [];
        $travelFrom = Travel::where('startCityID',$city->id)->pluck('dropOfCityID');
        foreach ($travelFrom as $travel){
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


    public function getCityByType(Request $request){
        $vehicleType = $request->type;
        $startId = $request->from;

        if($startId != null){
            $listOfCities=[];
            if($vehicleType != null){
                $busType = BusType::where("vehicle_type", $vehicleType)->get();

                foreach($busType as $bust){
                    $listOfTravels = Travel::where("busType_id", $bust->id)->where("startCityId",$startId)->get();
                    foreach($listOfTravels as $travel){
                        $city = City::find($travel->dropOfCityId);
                        array_push($listOfCities , $city);
                    }
                }

                $listToSendUnioned= [];
                foreach($listOfCities as $city){
                    if(!in_array( $city,$listToSendUnioned)){
                        array_push($listToSendUnioned , $city);
                    }
                }
                return $listToSendUnioned;


            }
        }
        else{
            $vehicleType = $request->type;
        $listOfCities=[];
        if($vehicleType != null){

            // return $vehicleType;
            $busType = BusType::where("vehicle_type", $vehicleType)->get();

            foreach($busType as $bust){
                $listOfTravels = Travel::where("busType_id", $bust->id)->get();
                foreach($listOfTravels as $travel){
                    $city = City::find($travel->startCityId);
                    array_push($listOfCities , $city);
                }
            }

                $listToSendUnioned= [];
                foreach($listOfCities as $city){
                    if(!in_array($city,$listToSendUnioned)){
                        array_push($listToSendUnioned , $city);
                    }
                }
                return $listToSendUnioned;
        }
        return City::all();
        }

        return response()->json([]);
    }

}
