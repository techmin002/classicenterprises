<?php

use Illuminate\Support\Facades\Route;
use Modules\SupportDashboard\Http\Controllers\SupportDashboardController;

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

Route::group([], function () {
    Route::resource('supportdashboard', SupportDashboardController::class)->names('supportdashboard');
});
    // Route::get('supportdashboard', SupportDashboardController::class)->name('supportdashboard.create');
