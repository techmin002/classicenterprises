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
use Modules\Employee\Http\Controllers\LeaveController;
use Modules\Employee\Http\Controllers\LeaveTypeController;

Route::group(['middleware' => 'auth'], function () {
    Route::get('/employee', 'EmployeeController@index');
    Route::resource('leaves', 'LeaveController');
    Route::resource('leave-types', 'LeaveTypeController');
    route::get('/employee/checkin/status/{id}', [AttendanceController::class,'checkinStatus'])->name('employee.checkin.status');
    Route::get('employee/checkin/{id}',[AttendanceController::class,'checkin'])->name('employee.checkin');
    Route::get('/employee/checkout/{id}', [AttendanceController::class,'checkout'])->name('employee.checkout');
    Route::get('/employee/attendance', [AttendanceController::class,'index'])->name('attendance.index');
    Route::get('/employee/attendance/checkin/Request', [AttendanceController::class,'checkinRequest'])->name('attendance.checkin');
    Route::get('/employee/attendance/checkin/Request/status', [AttendanceController::class,'checkinRequestStatus'])->name('attendance.checkin.status');

    Route::post('/employee/attendance/checkin/Request/store', [AttendanceController::class,'checkinRequestStore'])->name('attendance.checkin.store');
    Route::get('/employees/attendances', [AttendanceController::class,'attendanceAll'])->name('attendance.all');

    Route::get('/employee/attendance/checkout/Request', [AttendanceController::class,'checkoutRequest'])->name('attendance.checkout');
    Route::post('/employee/attendance/checkout/Request/store', [AttendanceController::class,'checkoutRequestStore'])->name('attendance.checkout.store');
    Route::get('/employee/attendance/checkout/Request/status', [AttendanceController::class,'checkoutRequestStatus'])->name('attendance.checkout.status');


});
