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
use Modules\Expenses\Http\Controllers\ExpensesController;

Route::group(['middleware' => 'auth'], function () {
    Route::resource('expenses', ExpensesController::class);
    Route::get('expense/status/{id}', [ExpensesController::class, 'status'])->name('expenses.status');
    Route::get('get-expenses', [ExpensesController::class,'getExpense'])->name('getExpenses');

});
