<?php

use App\Http\Controllers\flightBookingController;
use App\Http\Controllers\flightsController;
use App\Http\Controllers\hotelBookingController;
use App\Http\Controllers\hotelController;
use App\Http\Controllers\CarOfficeController;
use App\Http\Controllers\CarsController;
use App\Http\Controllers\CarBookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\favoritesController;
use App\Http\Controllers\tourismDestController;
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

// Testing Hotels 
Route::get('hotel/all', [hotelController::class, 'all']);
Route::get('hotel/country/{id}', [hotelController::class, 'hotelsByCountry']);
Route::get('hotel/{id}', [hotelController::class, 'getHotel']);

// Testing Car Offices
Route::get('all_offices', [CarOfficeController::class, 'index']);
Route::get('officeIn/country/{id}' , [CarOfficeController::class , 'officeByCountry']);

// Cars 
Route::get('all_Cars', [CarsController::class, 'index']);
Route::get('carsInOffice/{id}', [CarsController::class, 'carsInOffice']);

//category
Route::get('ctagories/all', [CategoryController::class, 'index']);
Route::get('destByCateg/{cat_id}', [CategoryController::class, 'search']);

//country
Route::get('countries/all', [CountryController::class, 'index']);
Route::get('popular', [CountryController::class, 'popular']);
Route::get('search_country/{name}', [CountryController::class, 'search']);
Route::get('country/det/{id}', [CountryController::class, 'details']);

// Destinations Tourism
Route::get('dest/all', [tourismDestController::class, 'all']);
Route::get('destByCountry/{id}' , [tourismDestController::class , 'getDestByCountry']);
Route::get('search_dest/{name}', [tourismDestController::class, 'search']);


// Flights
Route::get('flight/all', [flightsController::class, 'allFlights']);
Route::get('flightByID/{id}', [flightsController::class, 'getFlightBy']);
Route::get('flight/search/{name}', [flightsController::class, 'search']);


Route::group(['prefix' => 'user', 'middleware' => ['auth:user-api', 'scopes:user']], function () {
    // authenticated staff routes here 

    // Hotel Booking
    Route::post('bookHotel/{id}' , [hotelBookingController::class , 'bookHotel']);
    Route::get('allResrevations' , [hotelBookingController::class , 'allResrevation']);
    
    
    // Booking Car
    Route::post('bookCar', [CarBookController::class, 'bookCar']);
    Route::get('allReserv/car', [CarBookController::class, 'index']);

    // Add Destenatin To Faovrite 
    Route::get('addToFav/{id}', [favoritesController::class, 'addToFav']);
    Route::get('allFav' , [favoritesController::class , 'allFav']);


    // Booking flight
    Route::post('flight/book/{id}' , [flightBookingController::class , 'bookFlight']);
    Route::get('all/res/flights' ,[flightBookingController::class , 'allReserv']);


    Route::get('logout', [LoginController::class, 'userLogout']);
});