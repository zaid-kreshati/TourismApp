<?php

use App\Http\Controllers\tourismDestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\hotelBookingController;
use App\Http\Controllers\CarOfficeController;

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


//Car Office (add,delete,update)
Route::post('add_CarOffice', [CarOfficeController::class, 'store']);
Route::delete('delete_CarOffice/{id}', [CarOfficeController::class, 'destroy']);
Route::post('update_CarOffice/{id}', [CarOfficeController::class, 'update']);


//category (add,delete,update)
Route::post('add_category', [CategoryController::class, 'store']);
Route::delete('delete_category/{id}', [CategoryController::class, 'destroy']);
Route::post('update_category/{id}', [CategoryController::class, 'update']);

//Car (add,delete,update)
Route::post('add_Car', [CarsController::class, 'store']);
Route::delete('delete_Car/{id}', [CarsController::class, 'destroy']);
Route::post('update_Car/{id}', [CarsController::class, 'update']);


Route::group(['prefix' => 'admin', 'middleware' => ['auth:admin-api', 'scopes:admin']], function () {
    // authenticated staff routes here 
    

    Route::get('logout' , [LoginController::class , 'adminLogout']);
});