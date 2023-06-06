<?php

use App\Http\Controllers\tourismDestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\hotelBookingController;

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


Route::get('admin/get/{id}' , [hotelBookingController::class , 'getHotel']);

Route::group(['prefix' => 'admin', 'middleware' => ['auth:admin-api', 'scopes:admin']], function () {
    // authenticated staff routes here 
    

    Route::get('logout' , [LoginController::class , 'adminLogout']);
});