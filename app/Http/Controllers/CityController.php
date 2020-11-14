<?php

namespace App\Http\Controllers;

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



}
