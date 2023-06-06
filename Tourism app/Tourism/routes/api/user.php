<?php

use App\Http\Controllers\hotelBookingController;
use App\Http\Controllers\hotelController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

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

Route::post('user/login', [LoginController::class, 'userLogin'])->name('userLogin');
Route::post('user/register', [LoginController::class, 'userRegister'])->name('userRegister');

// Testing 
Route::get('hotel/all', [hotelController::class, 'all']);
Route::get('hotel/country/{id}', [hotelController::class, 'hotelsByCountry']);
Route::get('hotel/{id}', [hotelController::class, 'getHotel']);



Route::group(['prefix' => 'user', 'middleware' => ['auth:user-api', 'scopes:user']], function () {
    // authenticated staff routes here 

    // Hotel Booking
    Route::post('bookHotel' , [hotelBookingController::class , 'bookHotel']);
    Route::post('bookStore' , [hotelBookingController::class , 'bookStore']);
    
    // Hotels


    Route::get('logout', [LoginController::class, 'userLogout']);
});