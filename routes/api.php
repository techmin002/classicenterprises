<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\IndexController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});
Route::get('blogs', [BlogController::class,'index']);
Route::get('sliders', [IndexController::class, 'slider']);
Route::get('about', [IndexController::class, 'about']);
Route::post('contact-us', [IndexController::class, 'contactUs']);
Route::get('testimonials',[IndexController::class,'testimonials']);
Route::get('faqs',[IndexController::class,'faqs']);
Route::get('branches',[IndexController::class,'branches']);
Route::get('products',[IndexController::class,'products']);
Route::get('product/details/{id}',[IndexController::class,'productDetails']);
