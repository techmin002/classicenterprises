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

use Illuminate\Support\Facades\Route;
use Modules\Service\Http\Controllers\GalleryController;
use Modules\Service\Http\Controllers\ServiceController;
Route::group(['middleware' => 'auth'], function () {
    Route::resource('services', ServiceController::class);
    Route::resource('galleries', GalleryController::class);
    Route::get('service/status/{id}', [ServiceController::class,'status'])->name('services.status');
    Route::get('service-category/status/{id}', [ServiceCategoryController::class,'status'])->name('services_category.status');
    Route::resource('services_category', ServiceCategoryController::class);
});

