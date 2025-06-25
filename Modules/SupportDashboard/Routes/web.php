<?php

use Illuminate\Support\Facades\Route;
use Modules\SupportDashboard\Http\Controllers\SupportDashboardController;
use Modules\SupportDashboard\Http\Controllers\TaskController;

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
    Route::get('supportdashboard', [TaskController::class, 'create'])->name('supportdashboard.create');
    Route::post('supportdashboard/store', [TaskController::class, 'store'])->name('supportdashboard-task.store');
    Route::get('supportdashboard/queue', [TaskController::class, 'show'])->name('supportdashboard-task.queue');
    Route::get('supportdashboard/assign', [TaskController::class, 'assign'])->name('supportdashboard-task.assign');
    Route::post('supportdashboard/assignstore/{id}', [TaskController::class, 'assignstore'])->name('supportdashboard-task.assignstore');

    Route::post('supportdashboard/completestore/{id}', [TaskController::class, 'completestore'])->name('supportdashboard-task.completestore');
    Route::get('supportdashboard/complete', [TaskController::class, 'complete'])->name('supportdashboard-task.complete');
    Route::get('/task/complete/{id}/details', [TaskController::class, 'completeDetails'])->name('task.complete.details');


    // Route::resource('supportdashboard/task', SupportDashboardController::class)->names('supportdashboard');
    // Route::resource('supportdashboard-task', TaskController::class);

});
