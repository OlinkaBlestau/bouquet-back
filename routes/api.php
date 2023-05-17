<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BouquetController;
use App\Http\Controllers\Api\BouquetDecorsController;
use App\Http\Controllers\Api\BouquetFlowersController;
use App\Http\Controllers\Api\DecorController;
use App\Http\Controllers\Api\FlowerController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ShopController;
use App\Http\Controllers\Api\UploadController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'auth'], function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');
});

Route::group(['prefix' => 'image/upload'], function () {
    Route::post('/flower/{id}', [UploadController::class, 'uploadFlowerImage']);
    Route::post('/decor/{id}', [UploadController::class, 'uploadDecorImage']);
});

Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::put('/users/{id}', [UserController::class, 'update']);

Route::apiResource('bouquets', BouquetController::class);
Route::apiResource('decors', DecorController::class);
Route::apiResource('flowers', FlowerController::class);
Route::apiResource('orders', OrderController::class);
Route::apiResource('shops', ShopController::class);

Route::post('/bouquet-flowers', [BouquetFlowersController::class, 'store']);
Route::get('/bouquet-flowers/{id}', [BouquetFlowersController::class, 'show']);
Route::delete('/bouquet-flowers/{id}', [BouquetFlowersController::class, 'destroy']);

Route::post('/bouquet-decors', [BouquetDecorsController::class, 'store']);
Route::get('/bouquet-decors/{id}', [BouquetDecorsController::class, 'show']);
Route::delete('/bouquet-decors/{id}', [BouquetDecorsController::class, 'destroy']);

