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

            'userName' => 'required', //exists:companies,userName',
            'password' => 'required'

        ]);

        //return "it got here";

        $user = Admin::where('userName',$data['userName'])->first();


        if(!$user)
            return response('the provided username is incorrect');
        if (Hash::check($data['password'],$user->password))
        {
            $token = $user->createToken($data['userName'])->plainTextToken;
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

        $request->session()->regenerate();
//        Auth::logout();

        return "logged out";

    }

    public function index(Request $request)
    {


        return $request->user();

    }


}
