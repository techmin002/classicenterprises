<?php

use Illuminate\Support\Facades\Route;
use Modules\Finance\Http\Controllers\DailyCOllectionController;
use Modules\Finance\Http\Controllers\FinanceController;
use Modules\Finance\Http\Controllers\FirstBillController;

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
    Route::resource('finance', FinanceController::class)->names('finance');
    Route::resource('daily', DailyCOllectionController::class)->names('daily');
    Route::resource('firstbill', FirstBillController::class)->names('firstbill');

});
