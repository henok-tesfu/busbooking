<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\Sanctum;
use function PHPUnit\Framework\isNull;

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
    public function show()
    {
        if(auth()->check())
        return request()->user();
        else
        return response()->json(['An UnAuthorized'],401);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     *
     *
     */

    public function login(Request $request)
    {


        $data = $request->validate([

            'firebase_user_id' => [/*'exists:users,firebaseUserID',*/ 'required'],
            'phone_number' => '',
            'email' => '',
            //'notification_id'=>''

        ]);




        $firebaseID = User::where('firebase_user_id', $data['firebase_user_id'])->first();

        //dd($firebaseID);
        if (!$firebaseID)
        {

            $newUser = new User();
            $newUser->firebase_user_id = $data['firebase_user_id'];
            $newUser->phone_number = $data['phone_number'];
            $newUser->email = $data['email'];
            //$newUser->notification_id = $data['notification_id'];
            $newUser->save();

            $token = $newUser->createToken($data['firebase_user_id'])->plainTextToken;


            $newUser = User::where('firebase_user_id', $data['firebase_user_id'])->first();
            return response()->json(["user"=>$newUser, "token"=>$token], 200);
        } elseif ($firebaseID)
        {
            if (!$firebaseID['full_name'])
            {
                //dd($firebaseID,"this dont have username");
                $firebaseID->tokens()->delete();
                $token = $firebaseID->createToken($data['firebase_user_id'])->plainTextToken;
                //dd($firebaseID,"this dont have username");

                return response()->json(["user"=>$firebaseID, "token"=>$token], 200);
            }
            else
            {
                $firebaseID->tokens()->delete();
                $token = $firebaseID->createToken($data['firebase_user_id'])->plainTextToken;
                return response()->json(["user"=>$firebaseID, "token"=>$token], 200);
            }
        }


    }


    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

    }


    public function update(Request $request, User $user)
    {
        // add policy if the user is the owner
        //dd($user);
        //Sanctum::actingAs($user);
        //dd(auth()->check());
        // $display = $user->tokens()->first()->token;
        //dd($display);
       // return "here";
        $date = request()->validate([
            //'id'=>'exists:users,id',
            'full_name' => '',
            'phone_number' => '',
            'email' => ''
        ]);
        //return $request->user();// the user who is authorized



        $updateUser = auth()->user();
//        $fireBaseId = User::where('id',$updateUser->id)->whereNotNull('firebase_user_id')->firstOrFail();
//         return $fireBaseId;
        // if the user is the owner
       // also check the authorized person is a user
        if(auth()->check() && $updateUser->firebase_user_id)
        {
            if(isset($date['full_name']))
            $updateUser->full_name = $date['full_name'];
           // dd( isset($date['phone_number']));
            if(isset($date['phone_number']))
            $updateUser->phone_number = $date['phone_number'];
            if (isset($date['email']))
            $updateUser->email = $date['email'];
            $updateUser->save();
        }
        else
            {

           return "incorrect user";

            }


        return $updateUser;

    }

}
