<?php

use Illuminate\Support\Facades\Route;
use Modules\PetrolMGNT\Http\Controllers\BikeController;
use Modules\PetrolMGNT\Http\Controllers\PetrolController;
use Modules\PetrolMGNT\Http\Controllers\PetrolMGNTController;
use Modules\PetrolMGNT\Http\Controllers\BikeServiceController;

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


    Route::resource('service', BikeServiceController::class);
    // Route::get('service/status/{id}', [BikeServiceController::class, 'status'])->name('service.status');
    Route::get('bike-service/status/{id}', [BikeServiceController::class, 'status'])->name('bike-service.status');

});
