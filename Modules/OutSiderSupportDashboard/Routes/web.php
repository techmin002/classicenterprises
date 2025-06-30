<?php

use Illuminate\Support\Facades\Route;
use Modules\OutSiderSupportDashboard\Http\Controllers\OutSiderSupportDashboardController;
use Modules\OutSiderSupportDashboard\Http\Controllers\OutSideTaskController;

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
    Route::get('outsidersupportdashboard', [OutSideTaskController::class, 'index'])->name('outsidersupportdashboard.index');
    Route::post('outsidersupportdashboard/store', [OutSideTaskController::class, 'store'])->name('outsidersupportdashboard-task.store');
    Route::get('outsidersupportdashboard/assign', [OutSideTaskController::class, 'assign'])->name('outsidersupportdashboard-task.assign');
    Route::post('outsidersupportdashboard/assignstore/{id}', [OutSideTaskController::class, 'assignstore'])->name('outsidersupportdashboard-task.assignstore');

    Route::post('outsidersupportdashboard/completestore/{id}', [OutSideTaskController::class, 'completestore'])->name('outsidersupportdashboard-task.completestore');
    Route::get('outsidersupportdashboard/complete', [OutSideTaskController::class, 'complete'])->name('outsidersupportdashboard-task.complete');
    // Route::get('/task/complete/{id}/details', [OutSideTaskController::class, 'completeDetails'])->name('outsider.complete.details');

    Route::prefix('support')->name('outsider.')->group(function () {
        Route::get('/task/complete/{id}/details', [OutSideTaskController::class, 'completeDetails'])->name('complete.details');
    });
});
