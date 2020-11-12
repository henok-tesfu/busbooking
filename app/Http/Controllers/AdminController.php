<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{




    public  function login(Request $request)
    {
        //dd($request);
        $data =$request->validate([

            'user_name' => 'required', //exists:companies,userName',
            'password' => 'required'

        ]);



        $user = Admin::where('user_name',$data['user_name'])->first();

       //dd($user);
        if(!$user)
            return response('the provided username is incorrect');
        if (Hash::check($data['password'],$user->password))
        {
            $user->tokens()->delete();
            $token = $user->createToken($data['user_name'])->plainTextToken;
                 return response([$user,$token])->withCookie($token);
        }


        return response([
            'password' => ['The provided credentials are incorrect.'],
        ],402);

    }
    public function logout(Request $request)
    {

        $this->guard()->logout();

        $request->session()->flush();
// $request->user()->currentAccessToken()->delete();
        $request->session()->regenerate();
//        Auth::logout();

        return "logged out";

    }

    public function index(Request $request)
    {

//        dd($request->bearerToken());
  //      dd(auth()->guard('sanctum')->user());
        return $request->user();

    }


}
