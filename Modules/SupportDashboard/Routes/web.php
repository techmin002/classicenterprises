<?php

use Illuminate\Support\Facades\Route;
use Modules\SupportDashboard\Http\Controllers\AmcCustomerController;
use Modules\SupportDashboard\Http\Controllers\OutsiderCustomerController;
use Modules\SupportDashboard\Http\Controllers\RegisterCustomerController;
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

    Route::get('ticket/index', [TicketController::class, 'index'])->name('ticket.index');

    // -----------------------------
    // Register Customer Ticket Routes
    // -----------------------------
    Route::prefix('registercustomer-ticket')->group(function () {

        Route::get('/dashboard', [RegisterCustomerController::class, 'dashboard'])->name('registercustomer-ticket.dashboard');
        Route::get('/regular', [RegisterCustomerController::class, 'regular'])->name('registercustomer-ticket.regular');
        Route::get('/warrenty', [RegisterCustomerController::class, 'warrenty'])->name('registercustomer-ticket.warrenty');

        Route::post('/store', [RegisterCustomerController::class, 'store'])->name('registercustomer-ticket.store');
        Route::get('/queue', [RegisterCustomerController::class, 'queue'])->name('registercustomer-ticket.queue');
        Route::put('/messageupdate/{id}', [RegisterCustomerController::class, 'messageupdate'])->name('registercustomer-ticket.message.update');
        Route::put('/assignstore/{id}', [RegisterCustomerController::class, 'assignStore'])->name('registercustomer-assign.store');
        Route::get('/assign', [RegisterCustomerController::class, 'assign'])->name('registercustomer-ticket.assign');
        Route::get('/{id}', [RegisterCustomerController::class, 'create'])->name('registercustomer-ticket.create');
        Route::post('/store/{id}', [RegisterCustomerController::class, 'storeregistercustomer'])->name('store.registercustomer');
        Route::get('/ticket/report', [RegisterCustomerController::class, 'report'])->name('registercustomer-ticket.report');
        Route::get('/ticket/complete', [RegisterCustomerController::class, 'complete'])->name('registercustomer-ticket.complete');
    });

    // -----------------------------
    // Outsider Customer Ticket Routes
    // -----------------------------
    Route::prefix('outsidercustomer-ticket')->group(function () {

        Route::get('/dashboard', [OutsiderCustomerController::class, 'dashboard'])->name('outsidercustomer-ticket.dashboard');
        Route::get('/regular-service', [OutsiderCustomerController::class, 'regular_service'])->name('outsidercustomer-ticket.regular-service');
        Route::post('/customer-create', [OutsiderCustomerController::class, 'customercreate'])->name('outsidercustomer-ticket.customer-create');

        Route::post('/ticket/store/{id}', [OutsiderCustomerController::class, 'store'])->name('outsidercustomer-ticket.store');
        Route::get('/queue', [OutsiderCustomerController::class, 'queue'])->name('outsidercustomer-ticket.queue');
        Route::put('/messageupdate/{id}', [OutsiderCustomerController::class, 'messageupdate'])->name('outsidercustomer-ticket.message.update');
        Route::put('/assignstore/{id}', [OutsiderCustomerController::class, 'assignStore'])->name('outsidercustomer-assign.store');
        Route::get('/assign', [OutsiderCustomerController::class, 'assign'])->name('outsidercustomer-ticket.assign');
        Route::get('/{id}', [OutsiderCustomerController::class, 'create'])->name('outsidercustomer-ticket.create');
        Route::post('/store/{id}', [OutsiderCustomerController::class, 'storeoutsidercustomer'])->name('store.outsidercustomer');
        Route::get('/ticket/report', [OutsiderCustomerController::class, 'report'])->name('outsidercustomer-ticket.report');
        Route::get('/ticket/complete', [OutsiderCustomerController::class, 'complete'])->name('outsidercustomer-ticket.complete');
        Route::post('/ticket_create', [OutsiderCustomerController::class, 'ticket_create'])->name('outsidercustomer-ticket.ticket_create');

        Route::post('/ticket/create/{id}', [OutsiderCustomerController::class, 'ticketcreate'])->name('outsider-ticket.create');

    });

    Route::prefix('amccustomer-ticket')->group(function () {

        Route::get('/inservice', [AmcCustomerController::class, 'inservice'])->name('amccustomer-ticket.inservice');
        Route::get('/outservice', [AmcCustomerController::class, 'outservice'])->name('amccustomer-ticket.outservice');
        Route::get('/dashboard', [AmcCustomerController::class, 'dashboard'])->name('amccustomer-ticket.dashboard');
        Route::post('/store', [AmcCustomerController::class, 'store'])->name('amccustomer-ticket.store');
        Route::get('/queue', [AmcCustomerController::class, 'queue'])->name('amccustomer-ticket.queue');
        Route::put('/messageupdate/{id}', [AmcCustomerController::class, 'messageupdate'])->name('amccustomer-ticket.message.update');
        Route::put('/assignstore/{id}', [AmcCustomerController::class, 'assignStore'])->name('amccustomer-assign.store');
        Route::get('/assign', [AmcCustomerController::class, 'assign'])->name('amccustomer-ticket.assign');
        Route::get('/{id}', [AmcCustomerController::class, 'create'])->name('amccustomer-ticket.create');
        Route::post('/store/{id}', [AmcCustomerController::class, 'storeamccustomer'])->name('store.amccustomer');
        Route::get('ticket/report', [AmcCustomerController::class, 'report'])->name('amccustomer-ticket.report');
        Route::get('ticket/complete', [AmcCustomerController::class, 'complete'])->name('amccustomer-ticket.complete');
    });

    Route::get('ticket_customer/details/{id}', [TicketController::class, 'customerDetails'])->name('ticket_customer.details');
});