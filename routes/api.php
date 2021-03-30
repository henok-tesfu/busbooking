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
Route::middleware('auth:sanctum')->group(['prefix' => '/admin'], function() {
     
    //company
	Route::get('/companies', [CompanyController::class,'adminIndex']);
	Route::post('/companies',[CompanyController::class,'store']);
	Route::post('/companies/add-account',[CompanyController::class,'addAccount']);
	Route::get('/companies/{company}',[CompanyController::class,'show']);
	Route::post('/companies/{company}',[CompanyController::class,'update']);
    
    	// order
	Route::get('/orders',[OrderController::class,'list']);
    
    // travel profiles
	Route::get('/travel-profiles',[TravelProfileController::class,'index']);
	Route::post('/travel-profiles',[TravelProfileController::class,'store']);
    
    
	// Travel	
	Route::get('/travels',[TravelController::class,'adminIndex']);
	Route::post('/travels',[TravelController::class,'create']);
    
    // Cities	
	Route::get('/cities',[CityController::class,'adminIndex']);
	Route::post('/cities',[CityController::class,'store']);
	Route::post('/cities/{city}',[CityController::class,'update']);
    
    // Bus type	
	Route::get('/bus-types',[BusTypeController::class,'index']);
	Route::post('/bus-types',[BusTypeController::class,'store']);
	Route::get('/bus-types/{bus_type}',[BusTypeController::class,'show']);
	Route::post('/bus-types/{bus_type}',[BusTypeController::class,'update']);
});


Route::middleware('auth:sanctum')->group( function() {
	
//company

Route::post('/companies',[CompanyController::class,'store']);
Route::get('/companies/{company}',[CompanyController::class,'show']);
Route::post('/companies/{company}',[CompanyController::class,'update']);

//admin

Route::get('/admin/login','App\Http\Controllers\AdminController@index');
Route::post('/logout','App\Http\Controllers\AdminController@logout');
// Route::post('/login',[AdminController::class, 'login']);



//user

Route::get('/user',[UserController::class,'show']);
Route::post('/user/{user}/update',[UserController::class,'update']);
Route::post('/user/logout',[UserController::class,'logout']);




//create if only super admin
Route::get('/city/create',[CityController::class,'create']);
Route::post('/city/update',[CityController::class,'store']);

//travel
Route::post('/book-travel',[TravelController::class,'bookTravel']);
Route::post('/book-travel/order',[TravelController::class,'order']);

 //**************Travel for Company
Route::get('/travel',[TravelController::class,'index']);
Route::post('/travel/create',[TravelController::class,'create']);

Route::get('/travel/{travel}',[TravelController::class,'show']);

Route::get('/travel/admin/{travel}',[TravelController::class,'showAdmin']);



//Payment
Route::post('/payment-for-order',[PaymentController::class,'payForTicket']);


//user order
Route::get('/orders',[OrderController::class,'orderedList']);
Route::get('/orders/{order}',[OrderController::class,'show']);

//admin order
Route::get('/orders-list',[OrderController::class,'index']);

//checker
Route::get('/validate/{ticket}',[CheckerController::class,'validateTicket']);
Route::get('/scanned-tickets',[ScannedTicketController::class,'index']);

	
});

//company
Route::get('/companies', [CompanyController::class,'index']);


//admin
Route::post('/login',[AdminController::class, 'login']);

//user
Route::post('/user/login',[UserController::class,'login']);


//city
Route::get('/citybus',[CityController::class,'index']);
Route::post('/city/category',[CityTransportController::class,'index']);
Route::get('/city/{busType}/from/{city}/',[CityTransportController::class,'travelFrom']);

//city modified
Route::get('/city',[CityController::class,'getCityByType']);


//travel
Route::post('/city/available-travel',[TravelController::class,'availableTravel']);
Route::get('/reserved-seats/{travel}',[TravelController::class,'reservedSeats']);


 //**************Travel for Company
Route::get('/travel/{travel}',[TravelController::class,'show']);


//Bank
Route::get('/bank',[BankController::class,'index']);






