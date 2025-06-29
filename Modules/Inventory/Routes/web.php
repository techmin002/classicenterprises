<?php

use Illuminate\Support\Facades\Route;
use Modules\Inventory\Http\Controllers\InventoryController;
use Modules\Inventory\Http\Controllers\SupplierController;
use Modules\Inventory\Http\Controllers\DevicePurchaseController;
use Modules\Inventory\Http\Controllers\SalesController;
use Modules\Inventory\Http\Controllers\StockController;

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
    Route::resource('inventory', InventoryController::class)->names('inventory');
});

Route::group(['middleware' => 'auth'], function () {
    // Supplier Routes
    Route::resource('suppliers', SupplierController::class)->names('suppliers');
    Route::post('suppliers/store', [SupplierController::class, 'store'])->name('suppliers_store');
    Route::get('suppliers/{supplier}/edit', [SupplierController::class, 'edit'])->name('suppliers_edit');
    Route::put('suppliers/{supplier}', [SupplierController::class, 'update'])->name('suppliers_update');
    Route::delete('suppliers/{supplier}', [SupplierController::class, 'destroy'])->name('suppliers_destroy');

    // Device Purchase Routes
    Route::resource('device-purchases', DevicePurchaseController::class)->names('device-purchases');
    Route::get('device-purchases/{devicePurchase}/edit', [DevicePurchaseController::class, 'edit'])->name('device_purchase_edit');
    Route::put('device-purchases/{devicePurchase}', [DevicePurchaseController::class, 'update'])->name('device_purchases_update');
    Route::delete('device-purchases/{devicePurchase}', [DevicePurchaseController::class, 'destroy'])->name('device_purchase_destroy');
    Route::get('inventries', [DevicePurchaseController::class, 'getInventories'])->name('inventries');
    Route::get('device_purchase_machineries_accessories/{id}', [DevicePurchaseController::class, 'showMachineriesAccessories'])
        ->name('device_purchase_machineries_accessories');

    // Sales Routes
    Route::resource('sales', SalesController::class)->names('sales');
    Route::post('/sales', [SalesController::class, 'store'])->name('sales_store');
    Route::get('sales/{id}/details', [SalesController::class, 'showDetails'])->name('sales.details');

    // Stock Transfer
    Route::resource('stock-transfers', StockController::class)->names('stock-transfers');

});