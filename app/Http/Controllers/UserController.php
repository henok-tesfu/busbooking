<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $request->user();
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
     *
     *
     */

    public function login(Request $request)
    {

        //dd($request);
        $data = $request->validate([

            'firebaseUserID' => [/*'exists:users,firebaseUserID',*/'required'],
            'phone_number' => 'required',
            'email' => 'email|required'

        ]);

       //   dd($data);
        $firebaseID = User::where('firebaseUserID',$data['firebaseUserID'])->first();

                    //dd($firebaseID);
        if(!$firebaseID)
        {
           /* $newUser = User::create([
                'id'=>2,
                'username'=>'test',
                'firebaseUserID' => $data('firebaseUserID'),
                'phone_number' => $data('phone_number'),
                'email' => $data('email')

            ]);*/
            $newUser = new User();
            $newUser->firebaseUserID = $data['firebaseUserID'];
            $newUser->phone_number = $data['phone_number'];
            $newUser->email = $data['email'];
            $newUser->save();

            $token =$newUser->createToken($data['firebaseUserID'])->plainTextToken;
            $newUser = User::where('firebaseUserID',$data['firebaseUserID'])->first();
            return response([$newUser,$token,"user never existed"],402);
        }

       elseif($firebaseID)
       {
         if(!$firebaseID['username'])
         {
             //dd($firebaseID,"this dont have username");
                $token =$firebaseID->createToken($data['firebaseUserID'])->plainTextToken;
             //dd($firebaseID,"this dont have username");
             return response([$firebaseID,"user name not found"],402)->withCookie($token);
         }
         else {
             $token =$firebaseID->createToken($data['firebaseUserID'])->plainTextToken;
             return response([$firebaseID,$token],202);
         }
       }


    }


    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
