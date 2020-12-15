<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;

class TravelProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $profiles = Profile::where('company_id', $request->user()->company_id)->orderBy('created_at', 'desc')->paginate(10);

        return $profiles;
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
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'travels' => 'required'
        ]);

        $data['company_id'] = $request->user()->company_id;

        $profile = Profile::create($data);

        $profile->travels()->sync($request->travels);

        return $profile;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TravelProfileController  $travelProfileController
     * @return \Illuminate\Http\Response
     */
    public function show(TravelProfileController $travelProfileController)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TravelProfileController  $travelProfileController
     * @return \Illuminate\Http\Response
     */
    public function edit(TravelProfileController $travelProfileController)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TravelProfileController  $travelProfileController
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TravelProfileController $travelProfileController)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TravelProfileController  $travelProfileController
     * @return \Illuminate\Http\Response
     */
    public function destroy(TravelProfileController $travelProfileController)
    {
        //
    }
}
