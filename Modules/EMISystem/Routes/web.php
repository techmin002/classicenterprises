<?php

use Illuminate\Support\Facades\Route;
use Modules\EMISystem\Http\Controllers\EMISystemController;

Route::group(['middleware' => ['web', 'auth']], function () {
    // Main EMI System route
    Route::get('emi-system', [EMISystemController::class, 'index'])->name('emi.system.index');
    
    // EMI Plans DataTable route
    Route::get('emi-system/plans/data', [EMISystemController::class, 'plansDataTable'])->name('emi.system.datatable');
    
    // EMI Plan CRUD routes
    Route::post('emi-system/store', [EMISystemController::class, 'store'])->name('emi.system.store');
    Route::get('emi-system/{id}/edit', [EMISystemController::class, 'edit'])->name('emi.system.edit');
    Route::put('emi-system/{id}', [EMISystemController::class, 'update'])->name('emi.system.update');
    Route::delete('emi-system/{id}', [EMISystemController::class, 'destroy'])->name('emi.system.destroy');
});