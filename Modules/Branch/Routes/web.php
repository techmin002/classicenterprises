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

use Illuminate\Support\Facades\Route; // Corrected to use the Route facade
use Modules\Branch\Http\Controllers\BranchController;

Route::group(['middleware' => 'auth'], function () {
    Route::resource('branches', 'BranchController')->names('branches');
    Route::get('switch/branch/{id}',[BranchController::class,'switch'])->name('switch.branch');
});
