<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\TravelController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CheckerController;
use Illuminate\Support\Facades\App;
use APP\Http\Controllers;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


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





//company
Route::get('/company', [[CompanyController::class,'index']]);
Route::middleware('auth:sanctum')->post('/company/create',[CompanyController::class,'create']);


//admin
Route::post('/login',[AdminController::class, 'login']);
Route::middleware('auth:sanctum')->get('/admin/login','App\Http\Controllers\AdminController@index');
Route::post('/logout','App\Http\Controllers\AdminController@logout');
// Route::post('/login',[AdminController::class, 'login']);



//user
Route::post('/user/login',[UserController::class,'login']);
//Route::middleware('auth:sanctum')->get('/user/edit',[UserController::class,'index']);
Route::middleware('auth:sanctum')->post('/user/{user}/update',[UserController::class,'update']);
Route::middleware('auth:sanctum')->post('/user/logout',[UserController::class,'logout']);


//city
Route::get('/city',[CityController::class,'index']);
Route::get('/city/from/{city}',[CityController::class,'travelFrom']);

//create if only super admin
Route::middleware('auth:sanctum')->get('/city/create',[CityController::class,'create']);
Route::middleware('auth:sanctum')->post('/city/update',[CityController::class,'store']);

//travel

Route::post('/city/available-travel',[TravelController::class,'availableTravel']);
Route::get('/reserved-seats/{travel}',[TravelController::class,'reservedSeats']);
Route::middleware('auth:sanctum')->post('/book-travel',[TravelController::class,'bookTravel']);
Route::middleware('auth:sanctum')->post('/book-travel/order',[TravelController::class,'order']);

 //**************Travel for Company
Route::middleware('auth:sanctum')->get('/travel',[TravelController::class,'index']);
Route::middleware('auth:sanctum')->post('/travel/create',[TravelController::class,'create']);


//Bank
Route::get('/bank',[BankController::class,'index']);

//Payment
Route::middleware('auth:sanctum')->post('/payment-for-order',[PaymentController::class,'payForTicket']);


//user order
Route::middleware('auth:sanctum')->get('/orders',[OrderController::class,'orderedList']);

//admin order
Route::middleware('auth:sanctum')->get('/orders-list',[OrderController::class,'index']);

//checker
Route::middleware('auth:sanctum')->get('/validate/{ticket}',[CheckerController::class,'validateTicket']);






