<?php

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

use Modules\Lead\Http\Controllers\LeadController;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => 'auth'], function () {
    Route::resource('leads', 'LeadController');
    Route::get('hot-leads',[LeadController::class,'hotLeads'])->name('hot-leads');
    Route::get('warm-leads',[LeadController::class,'warmLeads'])->name('warm-leads');
    Route::get('cold-leads',[LeadController::class,'coldLeads'])->name('cold-leads');
});
