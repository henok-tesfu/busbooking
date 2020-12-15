<?php

namespace App\Http\Controllers;

use App\Models\BusType;
use Illuminate\Http\Request;

class BusTypeController extends Controller
{

    public function index()
    {
        $bus_types = BusType::orderBy('created_at', 'desc')->paginate(10);

        return $bus_types;
    }

    protected function create(Request $request)
    {
        $data = $request->validate([
            'vehicle_type'=>['required','exists:bus_types,id'],
            'left_column_spam'=>['required'],
            'left_row_spam'=>['required'],
            'right_column_spam'=>['required'],
            'right_row_spam'=>['required'],
            'back_seat'=>['required'],
            'capacity'=>['required']
        ]);
        if (auth()->check())
        {
         $create = BusType::create($data);
         return $create;
        }else
        {
            return response()->json(['UnAuthorized user']);

        }
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'name'=> ['required'],
            'vehicle_type'=>['required'],
            'left_column_spam'=>['required'],
            'left_row_spam'=>['required'],
            'right_column_spam'=>['required'],
            'right_row_spam'=>['required'],
            'back_seat'=>['required'],
            'capacity'=>['required']
        ]);

        $bus_type = BusType::create($data);

        return $bus_type;
    }


    public function show(BusType $bus_type)
    {
        return $bus_type;
    }


    public function update(Request $request, BusType $bus_type)
    {
        $data = $request->validate([
            'name'=> ['required'],
            'vehicle_type'=>['required'],
            'left_column_spam'=>['required'],
            'left_row_spam'=>['required'],
            'right_column_spam'=>['required'],
            'right_row_spam'=>['required'],
            'back_seat'=>['required'],
            'capacity'=>['required']
        ]);

        $response = BusType::where('id', $bus_type->id)->update($data);
        return $response;
    }
}
