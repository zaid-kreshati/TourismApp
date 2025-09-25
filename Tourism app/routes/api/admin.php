<?php

use App\Http\Controllers\CountryController;
use App\Http\Controllers\flightsController;
use App\Http\Controllers\tourismDestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\hotelBookingController;
use App\Http\Controllers\CarOfficeController;
use App\Http\Controllers\hotelController;
use App\Http\Controllers\CarsController;
use App\Http\Controllers\CategoryController;

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




Route::post('admin/login', [LoginController::class, 'adminLogin'])->name('adminLogin');
Route::post('admin/register', [LoginController::class, 'adminRegister'])->name('adminRegister');

Route::post('admin/upload' , [hotelBookingController::class , 'test']);
Route::post('admin/add' , [tourismDestController::class , 'add']);

// Hotels
Route::get('admin/getHotel/{id}' , [hotelBookingController::class , 'getHotel']);
// Add Hotel
Route::post('admin/hotel/add' , [hotelController::class , 'add']);


//Car Office (add,delete,update)
Route::post('add_CarOffice', [CarOfficeController::class, 'store']);
Route::delete('delete_CarOffice/{id}', [CarOfficeController::class, 'destroy']);
Route::post('update_CarOffice/{id}', [CarOfficeController::class, 'update']);


//category (add,delete,update)
Route::post('add_category', [CategoryController::class, 'store']);
Route::delete('delete_category/{id}', [CategoryController::class, 'destroy']);
Route::post('update_category/{id}', [CategoryController::class, 'update']);

//Car (add,delete,update)
Route::post('admin/add_Car', [CarsController::class, 'add']);
Route::delete('delete_Car/{id}', [CarsController::class, 'destroy']);
Route::post('update_Car/{id}', [CarsController::class, 'update']);


// Add Country
Route::post('admin/country/add', [CountryController::class, 'add']);

// Add Flight with image 
Route::post('flight/add', [flightsController::class, 'add']);

Route::group(['prefix' => 'admin', 'middleware' => ['auth:admin-api', 'scopes:admin']], function () {
    // authenticated staff routes here 


    // Add New Dest 
    Route::post('addDest', [tourismDestController::class, 'add']);

    Route::get('logout' , [LoginController::class , 'adminLogout']);
});