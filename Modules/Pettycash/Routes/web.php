<?php

use Illuminate\Support\Facades\Route;
use Modules\Pettycash\Http\Controllers\PettyCashAddController;
use Modules\Pettycash\Http\Controllers\PettyCashController;
use Modules\Pettycash\Http\Controllers\PettyCashRequestController;
use Modules\Pettycash\Http\Controllers\PettyCashTransferController;

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
    Route::resource('pettycash-addcash', PettyCashAddController::class);
<<<<<<< HEAD
    Route::post('pettycash-addcash/status/{id}', [PettyCashAddController::class, 'status'])->name('pettycash-addcash.status');
=======
    Route::get('pettycash-addcash/status/{id}', [PettyCashAddController::class, 'status'])->name('pettycash-addcash.status');

>>>>>>> ca9638b38c134a0ebcb29ff5d0438fc546d3b1b5
    // Route::get('pettycash-addcash/index', [PettyCashAddController::class, 'index'])->name('pettycash-addcash.index');
    // Route::post('pettycash-addcash/store', [PettyCashAddController::class, 'store'])->name('pettycash-addcash.store');
    // Route::put('pettycash-addcash/update/{id}', [PettyCashAddController::class, 'update'])->name('pettycash-addcash.update');
    // Route::delete('pettycash-addcash/destroy/{id}', [PettyCashController::class, 'destroy'])->name('pettycash-addcash.destroy');







    Route::resource('pettycash-request', PettyCashRequestController::class);
    // Route::post('pettycash-request/status/{id}', [PettyCashRequestController::class, 'status'])->name('pettycash-request.status');
    Route::post('pettycash-request/approve/{id}', [PettyCashRequestController::class, 'approve'])->name('pettycash-request.approve');
    Route::post('pettycash-request/reject/{id}', [PettyCashRequestController::class, 'reject'])->name('pettycash-request.reject');

    // Route::get('pettycash-request/index', [PettyCashRequestController::class, 'index'])->name('pettycash-request.index');

    Route::resource('pettycash-transfer', PettyCashTransferController::class);
    Route::post('pettycash-transfer/store/{id}', [PettyCashTransferController::class, 'store'])->name('petty-cash-transfer.store');



});
