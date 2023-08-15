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
Route::get('office/all', [CarOfficeController::class, 'index']);
Route::get('office/in/country/{id}' , [CarOfficeController::class , 'officeByCountry']);

// Cars 
Route::get('cars/all', [CarsController::class, 'index']);
Route::get('cars/in/office/{id}', [CarsController::class, 'carsInOffice']);


//category
Route::get('ctagories/all', [CategoryController::class, 'index']);
Route::get('destinations/ByCateg/{cat_id}', [CategoryController::class, 'search']);

//country
Route::get('countries/all', [CountryController::class, 'index']);
Route::get('countries/popular', [CountryController::class, 'popular']);
Route::get('countries/search/{name}', [CountryController::class, 'search']);
Route::get('country/details/{id}', [CountryController::class, 'details']);

// Destinations Tourism
Route::get('dest/all', [tourismDestController::class, 'all']);
Route::get('dest/in/country/{id}' , [tourismDestController::class , 'getDestByCountry']);
Route::get('dest/search/{name}', [tourismDestController::class, 'search']);


// Flights
Route::get('flight/all', [flightsController::class, 'allFlights']);
Route::get('flight/details/{id}', [flightsController::class, 'getFlightBy']);
Route::get('flight/search/{name}', [flightsController::class, 'search']);


Route::group(['prefix' => 'user', 'middleware' => ['auth:user-api', 'scopes:user']], function () {
    // authenticated staff routes here 

    // Hotel Booking
    Route::post('hotel/book/{id}' , [hotelBookingController::class , 'bookHotel']);
    Route::get('hotel/reserv/all' , [hotelBookingController::class , 'allResrevation']);
    
    
    // Booking Car
    Route::post('car/book/{id}', [CarBookController::class, 'bookCar']);
    Route::get('car/reserv/all', [CarBookController::class, 'index']);

    // Add Destenatin To Faovrite 
    Route::get('fav/add/{id}', [favoritesController::class, 'addToFav']);
    Route::get('fav/all' , [favoritesController::class , 'allFav']);


    // Booking flight
    Route::post('flight/book/{id}' , [flightBookingController::class , 'bookFlight']);
    Route::get('flight/resrv/all' ,[flightBookingController::class , 'allReserv']);


    Route::get('logout', [LoginController::class, 'userLogout']);
});