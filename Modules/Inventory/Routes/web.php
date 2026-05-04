<?php

use Illuminate\Support\Facades\Route;
use Modules\Inventory\Http\Controllers\DevicePurchaseController;
use Modules\Inventory\Http\Controllers\InventoryController;
use Modules\Inventory\Http\Controllers\SalesController;
use Modules\Inventory\Http\Controllers\StockController;
use Modules\Inventory\Http\Controllers\StockIssueController;
use Modules\Inventory\Http\Controllers\SupplierController;
use Modules\Inventory\Http\Controllers\TechnicianInventoryController;
use Modules\Inventory\Http\Controllers\SaleReturnController;
use Modules\Inventory\Http\Controllers\PreSaleController;

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
    // Route::resource('inventory', InventoryController::class)->names('inventory');
    Route::get('inventory', [InventoryController::class, 'index'])
        ->name('inventory.index');
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

    Route::get('inventries/accessories_details/{id}', [InventoryController::class, 'accessories_details'])->name('inventory.accessories');
    Route::get('inventries/machineries_details/{id}', [InventoryController::class, 'machineries_details'])->name('inventory.machineries');
    Route::get('inventries/technicaltools_details/{id}', [InventoryController::class, 'technicaltools_details'])->name('inventory.technicaltools');

    // Sales Routes
    Route::resource('sales', SalesController::class)->names('sales');
    Route::post('/sales', [SalesController::class, 'store'])->name('sales_store');
    Route::get('sales/{id}/details', [SalesController::class, 'showDetails'])->name('sales.details');

    Route::prefix('pre-sales')->group(function () {
    Route::get('/', [PreSaleController::class, 'index'])->name('pre-sales.index');
    Route::post('/store', [PreSaleController::class, 'store'])->name('pre-sales.store');
    Route::post('/confirm/{id}', [PreSaleController::class, 'confirm'])->name('pre-sales.confirm');
});
Route::post('/pre-sales/{id}/cancel', [PreSaleController::class, 'cancel'])
    ->name('pre-sales.cancel');

    // Stock Transfer
    Route::resource('stock-transfers', StockController::class)->names('stock-transfers');

    Route::resource('stock-issue', StockIssueController::class)->names('stock-issue');
    Route::post('stock-issue/accept/{id}', [StockIssueController::class, 'accept'])->name('stock-issue.accept');
    Route::post('stock-issue/reject/{id}', [StockIssueController::class, 'reject'])->name('stock-issue.reject');
    Route::post('/stock-issue/{id}/receive', [StockIssueController::class, 'receive'])->name('stock-issue.receive');
Route::get('get-sale-items/{id}', [SaleReturnController::class,'getSaleItems'])
    ->name('get.sale.items');
Route::resource('sale-returns', SaleReturnController::class);


    Route::prefix('inventory/technicians')->group(function () {
        Route::get('/', [TechnicianInventoryController::class, 'index'])
            ->name('inventory.technicians.index');

        Route::get('{staff}', [TechnicianInventoryController::class, 'show'])
            ->name('inventory.technicians.show');

        // Assignment routes
        Route::get('{staff}/assign', [TechnicianInventoryController::class, 'createAssignment'])
            ->name('inventory.technicians.assign.create');

        Route::post('assign', [TechnicianInventoryController::class, 'storeAssignment'])
            ->name('inventory.technicians.assign.store');

        // Verify return
      Route::post(
    '{staffId}/verify/{itemType}/{itemId}',
    [TechnicianInventoryController::class, 'verifyReturn']
)->name('inventory.technicians.verify');


        // ✅ History route
        Route::get('{staff}/{item_type}/{item}', [TechnicianInventoryController::class, 'itemHistory'])
            ->name('inventory.technicians.itemHistory');
    });
});
