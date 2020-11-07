<?php

use App\Http\Controllers\CompanyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Company;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/company', 'App\Http\Controllers\CompanyController@index');
Route::get('/p', 'CompanyController@Index');

Route::get('/cp', function () {

    $con = Company::all();

        return $con->pluck('id');
});

Route::post('/company/create', function (Request $request){

     $date = $request->validate([
      'name'=>'required'

     ]);

     $newCompany = new Company();
     $newCompany->name = $date['name'];
     $newCompany->save();
    return "success created!";
});

Route::post('/login','App\Http\Controllers\AdminController@login');

