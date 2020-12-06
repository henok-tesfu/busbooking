<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::orderBy('created_at', 'desc')->paginate(10);

      return $companies;

    }


    public function addAccount(Request $request)
    {
        $data = $request->validate([
            'email' => 'required',
            'company_id' => 'required',
            'password' => 'required'
        ]);

        $data['type'] = 'company';
        $data['role_id'] = 4;
        $data['password'] = Hash::make($data['password']);

        $account = Admin::create($data);

        return $account;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        $date = $request->validate([
//            'name'=>'required|string'
//
//        ]);
//
//        $newCompany = new Company();
//        $newCompany->name = $date['name'];
//        $newCompany->save();
//        return "successfully created!";

        $data = $request->validate([
            'name'=>['required'],

        ]);
        $superAdmin = request()->user();
        if ($superAdmin->type == "booking_company")
        {
            $company = Company::create($data);

            if ($request->has('email') && $request->has('password')) {
                $data = [
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'type' => 'company',
                    'role_id' => 4,
                    'company_id' => $company->id
                ];

                $account = Admin::create($data);
            }
            return $company;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {

        return $company;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        $data = $request->validate([
            'name'=>'required'
        ]);
        $Admin = request()->user();

        if(auth()->check())
            $company->update($data);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        //
    }
}
