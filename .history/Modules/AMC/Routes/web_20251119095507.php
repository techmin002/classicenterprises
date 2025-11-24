<?php

use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use Modules\AMC\Http\Controllers\AmcAssignController;
use Modules\AMC\Http\Controllers\AMCController;

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
    Route::resource('amc', AMCController::class)->names('amc');
    Route::get('amc/status/{id}', [AMCController::class, 'status'])->name('amc.status');


    Route::resource('amcassign', AmcAssignController::class)->names('amcassign');
    Route::get('amcassign/status/{id}', [AmcAssignController::class, 'status'])->name('amcassign.status');
    Route::get('registercustomer/assign', [AmcAssignController::class, 'Registerassign'])->name('registercustomer.assign');
    Route::get('outsidercustomer/assign', [AmcAssignController::class, 'Outsiderassign'])->name('outsidercustomer.assign');
    Route::get('amcassign/status/{id}', [AmcAssignController::class, 'status'])->name('amcassign.status');




    Route::get('/amcassign/getAmcList/{type}', [AmcAssignController::class, 'getAmcList']);

    Route::get('/get-amc-amount/{id}', [AmcController::class, 'getAmcAmount']);
});
