<?php

use Illuminate\Support\Facades\Route;
use Modules\SupportDashboard\Http\Controllers\AmcCustomerController;
use Modules\SupportDashboard\Http\Controllers\OutsiderCustomerController;
use Modules\SupportDashboard\Http\Controllers\RegisterCustomerController;
use Modules\SupportDashboard\Http\Controllers\SupportDashboardController;
use Modules\SupportDashboard\Http\Controllers\TaskController;
use Modules\SupportDashboard\Http\Controllers\TicketController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!x
|
*/

Route::group(['middleware' => 'auth'], function () {
    Route::get('supportdashboard', [TaskController::class, 'create'])->name('supportdashboard.create');

    Route::post('supportdashboard/completestore/{id}', [TaskController::class, 'completestore'])->name('supportdashboard-task.completestore');
    Route::get('supportdashboard/complete', [TaskController::class, 'complete'])->name('supportdashboard-task.complete');
    Route::get('/task/complete/{id}/details', [TaskController::class, 'completeDetails'])->name('task.complete.details');


    Route::get('supportdashboard/index', [SupportDashboardController::class, 'index'])->name('supportdashboard.index');

    Route::get('ticket/index', [TicketController::class, 'index'])->name('ticket.index');


    Route::post('registercustomer-ticket/store', [RegisterCustomerController::class, 'store'])->name('registercustomer-ticket.store');
    Route::get('registercustomer-ticket/queue', [RegisterCustomerController::class, 'queue'])->name('registercustomer-ticket.queue');
    Route::put('/registercustomer-messageupdate/{id}', [RegisterCustomerController::class, 'messageupdate'])->name('registercustomer-ticket.message.update');
    Route::put('/registercustomer-assignstore/{id}', [RegisterCustomerController::class, 'assignStore'])->name('registercustomer-assign.store');
    Route::get('registercustomer-ticket/assign', [RegisterCustomerController::class, 'assign'])->name('registercustomer-ticket.assign');
    Route::get('/registercustomer-ticket/{id}', [RegisterCustomerController::class, 'create'])->name('registercustomer-ticket.create');
    Route::post('/registercustomer-store/{id}', [RegisterCustomerController::class, 'storeregistercustomer'])->name('store.registercustomer');
    Route::get('registercustomer-ticket/report', [RegisterCustomerController::class, 'report'])->name('registercustomer-ticket.report');
    Route::get('registercustomer-ticket/complete', [RegisterCustomerController::class, 'complete'])->name('registercustomer-ticket.complete');
    Route::get('register-customer/details/{id}', [RegisterCustomerController::class, 'customerDetails'])->name('registercustomer-ticket.details');


    // -----------------------------
    // Register Customer Ticket Routes
    // -----------------------------
    Route::prefix('registercustomer-ticket')->group(function () {
        
        Route::post('/store', [RegisterCustomerController::class, 'store'])->name('registercustomer-ticket.store');
        Route::get('/queue', [RegisterCustomerController::class, 'queue'])->name('registercustomer-ticket.queue');
        Route::put('/messageupdate/{id}', [RegisterCustomerController::class, 'messageupdate'])->name('registercustomer-ticket.message.update');
        Route::put('/assignstore/{id}', [RegisterCustomerController::class, 'assignStore'])->name('registercustomer-assign.store');
        Route::get('/assign', [RegisterCustomerController::class, 'assign'])->name('registercustomer-ticket.assign');
        Route::get('/report', [RegisterCustomerController::class, 'report'])->name('registercustomer-ticket.report');
        Route::get('/complete', [RegisterCustomerController::class, 'complete'])->name('registercustomer-ticket.complete');
        Route::get('/{id}', [RegisterCustomerController::class, 'create'])->name('registercustomer-ticket.create');
        
        Route::post('/store/{id}', [RegisterCustomerController::class, 'storeregistercustomer'])->name('store.registercustomer');
        Route::get('/details/{id}', [RegisterCustomerController::class, 'customerDetails'])->name('registercustomer-ticket.details');
    });




    Route::post('outsidercustomer-ticket/customer-create', [OutsiderCustomerController::class, 'customercreate'])->name('outsidercustomer-ticket.customer-create');
    Route::post('outsidercustomer-ticket/store/{id}', [OutsiderCustomerController::class, 'store'])->name('outsidercustomer-ticket.store');
    Route::get('outsidercustomer-ticket/queue', [OutsiderCustomerController::class, 'queue'])->name('outsidercustomer-ticket.queue');
    Route::put('/outsidercustomer-messageupdate/{id}', [OutsiderCustomerController::class, 'messageupdate'])->name('outsidercustomer-ticket.message.update');
    Route::put('/outsidercustomer-assignstore/{id}', [OutsiderCustomerController::class, 'assignStore'])->name('outsidercustomer-assign.store');
    Route::get('outsidercustomer-ticket/assign', [OutsiderCustomerController::class, 'assign'])->name('outsidercustomer-ticket.assign');
    Route::get('/outsidercustomer-ticket/{id}', [OutsiderCustomerController::class, 'create'])->name('outsidercustomer-ticket.create');
    Route::post('/outsidercustomer-store/{id}', [OutsiderCustomerController::class, 'storeoutsidercustomer'])->name('store.outsidercustomer');
    Route::get('/outsidercustomer-ticket/report', [OutsiderCustomerController::class, 'report'])->name('outsidercustomer-ticket.report');
    Route::get('/outsidercustomer-ticket/complete', [OutsiderCustomerController::class, 'complete'])->name('outsidercustomer-ticket.complete');
    Route::get('register-customer/details/{id}', [OutsiderCustomerController::class, 'customerDetails'])->name('outsidercustomer-ticket.details');



    Route::post('amccustomer-ticket/store', [AmcCustomerController::class, 'store'])->name('amccustomer-ticket.store');
    Route::get('amccustomer-ticket/queue', [AmcCustomerController::class, 'queue'])->name('amccustomer-ticket.queue');
    Route::put('/amccustomer-messageupdate/{id}', [AmcCustomerController::class, 'messageupdate'])->name('amccustomer-ticket.message.update');
    Route::put('/amccustomer-assignstore/{id}', [AmcCustomerController::class, 'assignStore'])->name('amccustomer-assign.store');
    Route::get('amccustomer-ticket/assign', [AmcCustomerController::class, 'assign'])->name('amccustomer-ticket.assign');
    Route::get('/amccustomer-ticket/{id}', [AmcCustomerController::class, 'create'])->name('amccustomer-ticket.create');
    Route::post('/amccustomer-store/{id}', [AmcCustomerController::class, 'storeamccustomer'])->name('store.amccustomer');
    Route::get('amccustomer-ticket/report', [AmcCustomerController::class, 'report'])->name('amccustomer-ticket.report');
    Route::get('amccustomer-ticket/complete', [AmcCustomerController::class, 'complete'])->name('amccustomer-ticket.complete');
    Route::get('amc-customer/details/{id}', [AmcCustomerController::class, 'customerDetails'])->name('amccustomer-ticket.details');
});
