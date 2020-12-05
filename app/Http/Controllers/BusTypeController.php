<?php

namespace App\Http\Controllers;

use App\Models\BusType;
use Illuminate\Http\Request;

class BusTypeController extends Controller
{

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
}
