<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CityTransportController;
use App\Http\Controllers\TravelController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CheckerController;
use App\Http\Controllers\BusTypeController;
use App\Http\Controllers\TravelProfileController;
use App\Http\Controllers\ScannedTicketController;
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



Route::group(['prefix' => '/admin'], function() {
	//company
	Route::middleware('auth:sanctum')->get('/companies', [CompanyController::class,'adminIndex']);
	Route::middleware('auth:sanctum')->post('/companies',[CompanyController::class,'store']);
	Route::middleware('auth:sanctum')->post('/companies/add-account',[CompanyController::class,'addAccount']);
	Route::middleware('auth:sanctum')->get('/companies/{company}',[CompanyController::class,'show']);
	Route::middleware('auth:sanctum')->post('/companies/{company}',[CompanyController::class,'update']);

	// order
	Route::middleware('auth:sanctum')->get('/orders',[OrderController::class,'list']);


	// travel profiles
	Route::middleware('auth:sanctum')->get('/travel-profiles',[TravelProfileController::class,'index']);
	Route::middleware('auth:sanctum')->post('/travel-profiles',[TravelProfileController::class,'store']);


	// Travel	
	Route::middleware('auth:sanctum')->get('/travels',[TravelController::class,'adminIndex']);
	Route::middleware('auth:sanctum')->post('/travels',[TravelController::class,'create']);


	// Cities	
	Route::middleware('auth:sanctum')->get('/cities',[CityController::class,'adminIndex']);
	Route::middleware('auth:sanctum')->post('/cities',[CityController::class,'store']);
	Route::middleware('auth:sanctum')->post('/cities/{city}',[CityController::class,'update']);


	// Bus type	
	Route::middleware('auth:sanctum')->get('/bus-types',[BusTypeController::class,'index']);
	Route::middleware('auth:sanctum')->post('/bus-types',[BusTypeController::class,'store']);
	Route::middleware('auth:sanctum')->get('/bus-types/{bus_type}',[BusTypeController::class,'show']);
	Route::middleware('auth:sanctum')->post('/bus-types/{bus_type}',[BusTypeController::class,'update']);
});

//company
Route::get('/companies', [CompanyController::class,'index']);
Route::middleware('auth:sanctum')->post('/companies',[CompanyController::class,'store']);
Route::middleware('auth:sanctum')->get('/companies/{company}',[CompanyController::class,'show']);
Route::middleware('auth:sanctum')->post('/companies/{company}',[CompanyController::class,'update']);

//admin
Route::post('/login',[AdminController::class, 'login']);
Route::middleware('auth:sanctum')->get('/admin/login','App\Http\Controllers\AdminController@index');
Route::post('/logout','App\Http\Controllers\AdminController@logout');
// Route::post('/login',[AdminController::class, 'login']);



//user
Route::post('/user/login',[UserController::class,'login']);

Route::middleware('auth:sanctum')->get('/user',[UserController::class,'show']);
Route::middleware('auth:sanctum')->post('/user/{user}/update',[UserController::class,'update']);
Route::middleware('auth:sanctum')->post('/user/logout',[UserController::class,'logout']);


//city
Route::get('/citybus',[CityController::class,'index']);
Route::post('/city/category',[CityTransportController::class,'index']);
Route::get('/city/{busType}/from/{city}/',[CityTransportController::class,'travelFrom']);

//city modified
Route::get('/city',[CityController::class,'getCityByType']);

//create if only super admin
Route::middleware('auth:sanctum')->get('/city/create',[CityController::class,'create']);
Route::middleware('auth:tsanctum')->post('/city/update',[CityController::class,'store']);

//travel


Route::post('/city/available-travel',[TravelController::class,'availableTravel']);
Route::get('/reserved-seats/{travel}',[TravelController::class,'reservedSeats']);
Route::middleware('auth:sanctum')->post('/book-travel',[TravelController::class,'bookTravel']);
Route::middleware('auth:sanctum')->post('/book-travel/order',[TravelController::class,'order']);

 //**************Travel for Company
Route::middleware('auth:sanctum')->get('/travel',[TravelController::class,'index']);
Route::middleware('auth:sanctum')->post('/travel/create',[TravelController::class,'create']);

Route::get('/travel/{travel}',[TravelController::class,'show']);

Route::middleware('auth:sanctum')->get('/travel/admin/{travel}',[TravelController::class,'showAdmin']);

//Bank
Route::get('/bank',[BankController::class,'index']);

//Payment
Route::middleware('auth:sanctum')->post('/payment-for-order',[PaymentController::class,'payForTicket']);


//user order
Route::middleware('auth:sanctum')->get('/orders',[OrderController::class,'orderedList']);
Route::middleware('auth:sanctum')->get('/orders/{order}',[OrderController::class,'show']);

//admin order
Route::middleware('auth:sanctum')->get('/orders-list',[OrderController::class,'index']);

//checker
Route::middleware('auth:sanctum')->get('/validate/{ticket}',[CheckerController::class,'validateTicket']);
Route::middleware('auth:sanctum')->get('/scanned-tickets',[ScannedTicketController::class,'index']);




