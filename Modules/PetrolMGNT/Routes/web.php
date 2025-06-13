<?php

use Illuminate\Support\Facades\Route;
use Modules\PetrolMGNT\Http\Controllers\BikeController;
use Modules\PetrolMGNT\Http\Controllers\PetrolController;
use Modules\PetrolMGNT\Http\Controllers\PetrolMGNTController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => 'auth'], function () {
    Route::resource('petrol', PetrolController::class);
    Route::get('petrol/status/{id}', [PetrolController::class, 'status'])->name('petrol.status');



    Route::resource('bike', BikeController::class);
    Route::get('bike/status/{id}', [BikeController::class, 'status'])->name('bike.status');



});
