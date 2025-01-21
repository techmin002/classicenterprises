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
    Route::post('response-store',[LeadController::class,'responseStore'])->name('response.store');
    Route::post('response-update/{id}',[LeadController::class,'responseUpdate'])->name('response.update');
    Route::delete('response-delete/{id}',[LeadController::class,'responseDelete'])->name('response.destroy');
    Route::get('followups',[LeadController::class,'followups'])->name('followups');
    Route::get('lead-convert/{id}',[LeadController::class,'leadToClient'])->name('lead.clients');
    Route::post('lead-convert/store/',[LeadController::class,'leadToClientStore'])->name('leads.convert.store');
    // web.php
    Route::get('/accessories', [LeadController::class, 'getAccessories'])->name('accessories.list');
    Route::get('/products', [LeadController::class, 'getProducts'])->name('products.get');

});
