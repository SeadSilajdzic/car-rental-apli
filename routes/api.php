<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Brand\BrandController;
use App\Http\Controllers\Api\Car\CarController;
use App\Http\Controllers\Api\Category\CategoryController;
use App\Http\Controllers\Api\User\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Authentication routes
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

// Public routes
Route::resource('/user', UserController::class)->only(['index', 'show']);
Route::resource('/car', CarController::class)->only(['index', 'show']);
Route::resource('/category', CategoryController::class)->only(['index', 'show']);
Route::resource('/brand', BrandController::class)->only(['index', 'show']);

Route::middleware('auth:sanctum')->group(function() {
    // Authenticated route
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    // Authenticated routes
    Route::resource('/user', UserController::class)->only(['store', 'update', 'destroy']);
    Route::resource('/car', CarController::class)->only(['store', 'update', 'destroy']);
    Route::resource('/category', CategoryController::class)->only(['store', 'update', 'destroy']);
    Route::resource('/brand', BrandController::class)->only(['store', 'update', 'destroy']);
});

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
