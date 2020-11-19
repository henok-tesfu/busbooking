<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\TravelController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\PaymentController;

use Illuminate\Support\Facades\App;
use APP\Http\Controllers;
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

        return $con;//->pluck('id');
});

Route::post('/company/create', function (Request $request){

     $date = $request->validate([
      'name'=>'required'

     ]);

     $newCompany = new Company();
     $newCompany->name = $date['name'];
     $newCompany->save();
    return "successfully created!";
});


//admin
Route::post('/login',[AdminController::class, 'login']);
Route::middleware('auth:sanctum')->get('/admin/login','App\Http\Controllers\AdminController@index');
Route::post('/logout','App\Http\Controllers\AdminController@logout');
Route::post('/login',[AdminController::class, 'login']);



//user
Route::post('/user/login','App\Http\Controllers\UserController@login');
//Route::middleware('auth:sanctum')->get('/user/edit',[UserController::class,'index']);
Route::middleware('auth:sanctum')->post('/user/{user}/update',[UserController::class,'update']);


//city
Route::get('/city',[CityController::class,'index']);
Route::get('/city/from/{city}',[CityController::class,'travelFrom']);
             //create if only super admin
Route::middleware('auth:sanctum')->get('/city/create',[CityController::class,'create']);
Route::middleware('auth:sanctum')->post('/city',[CityController::class,'store']);

//travelp
Route::post('/city/available-travel',[TravelController::class,'availableTravel']);
Route::get('/reserved-seats/{travel}',[TravelController::class,'reservedSeats']);
Route::middleware('auth:sanctum')->post('/book-travel',[TravelController::class,'bookTravel']);
Route::middleware('auth:sanctum')->post('/book-travel/order',[TravelController::class,'order']);
//ticket
Route::middleware('auth:sanctum')->get('/ordered',[TravelController::class,'orderedList']);
//Bank
Route::get('/bank',[BankController::class,'index']);

//Payment
Route::middleware('auth:sanctum')->post('/payment-for-order',[PaymentController::class,'payForTicket']);


//user order
Route::middleware('auth:sanctum')->get('/ticket',[PaymentController::class,'orderedList']);






