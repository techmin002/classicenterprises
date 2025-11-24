<?php

use Illuminate\Support\Facades\Route;
use Modules\Finance\Http\Controllers\DailyCOllectionController;
use Modules\Finance\Http\Controllers\FinanceController;
use Modules\Finance\Http\Controllers\FirstBillController;
use Modules\Finance\Http\Controllers\PaymentVerificationController;
use Modules\Finance\Http\Controllers\EMIPaymentController;

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

    Route::resource('emiPayment', EMIPaymentController::class)->names('emiPayment');
    Route::get('emi.payment.details/{id}', [EMIPaymentController::class, 'emiPaymentDetails'])->name('emi.payment.details');
   Route::post('/emi-payments/store', [EMIPaymentController::class, 'store'])->name('emi.payments.store');

    // Route::resource('payment-verification', PaymentVerificationController::class)->names('payment-verification.index');

    Route::get('payment-verification/index', [PaymentVerificationController::class, 'index'])->name('payment-verification.index');
    Route::post('/payment-verification/{id}', [PaymentVerificationController::class, 'store'])->name('payment-verification.store');


    Route::post('/closing-amount', [DailyCollectionController::class, 'storeClosingAmount'])->name('closing.amount.store');

    Route::post('/deposited/history/store', [DailyCollectionController::class, 'depositedHistorystore'])->name('deposite.history.store');

    Route::get('/deposite/history', [DailyCollectionController::class, 'depositedHistory'])->name('deposite.history');

    Route::get('/all-collection', [DailyCollectionController::class, 'AllCollection'])->name('all-collection');




});
