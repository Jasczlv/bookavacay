<?php

use App\Http\Controllers\Api\ApartmentController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
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
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('logout', [AuthController::class, 'logout']);
        Route::get('user', [AuthController::class, 'user']);
    });
});

Route::get('apartments/search', [ApartmentController::class, 'search']);
Route::post('/apartments/search', [ApartmentController::class, 'search']);
Route::get('apartments/services', [ApartmentController::class, 'services']);
Route::post('apartments/message', [ApartmentController::class, 'message']);
Route::apiResource('apartments', ApartmentController::class);
