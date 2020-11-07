<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{

    public  function login(Request $request)
    {
        //dd($request);
        $data =$request->validate([

            'userName' => 'required', //exists:companies,userName',
            'password' => 'required'

        ]);

        //return "it got here";
        //$user = Admin::where('userName', $data->userName)->first();
        $user = Admin::where('userName',$data['userName'])->first();

       //dd($data['userName']);
        if (! $user || auth()->attempt() ) {
            return response([
                'userName' => ['The provided credentials are incorrect.'],
            ],402);
        }

        return $user->createToken($data['userName'])->plainTextToken;

    }


}
