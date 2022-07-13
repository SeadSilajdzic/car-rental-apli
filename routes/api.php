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
Route::get('/car/{brand}/{model}/{from_price}/{to_price}/search', [CarController::class, 'searchCars']);
Route::resource('/car/{currency?}', CarController::class)->only(['index', 'show']);
Route::get('/category/{query}/search', [CategoryController::class, 'searchCategoryCars']);
Route::resource('/category', CategoryController::class)->only(['index', 'show']);
Route::resource('/brand', BrandController::class)->only(['index', 'show']);

Route::middleware('auth:sanctum')->group(function() {
    // Authenticated routes
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::resource('/user', UserController::class)->only(['store', 'update', 'destroy']);
    Route::resource('/car', CarController::class)->only(['store', 'update', 'destroy']);
    Route::resource('/category', CategoryController::class)->only(['store', 'update', 'destroy']);
    Route::resource('/brand', BrandController::class)->only(['store', 'update', 'destroy']);
});
