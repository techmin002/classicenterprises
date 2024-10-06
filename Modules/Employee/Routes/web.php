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

use Modules\Employee\Http\Controllers\AttendanceController;

Route::prefix('employee')->group(function() {
    Route::get('/', 'EmployeeController@index');
    Route::get('employee/checkin/{id}',[AttendanceController::class,'checkin'])->name('employee.checkin');
});
