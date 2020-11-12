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
        $travelFrom = Travel::where('startCityID',$city->id)->get();


    }
}
