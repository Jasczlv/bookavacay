<?php

use App\Http\Controllers\Api\ApartmentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('apartments/search', [ApartmentController::class, 'search']);
Route::post('/apartments/search', [ApartmentController::class, 'search']);
Route::get('apartments/services', [ApartmentController::class, 'services']);
Route::get('/check-login', function () {
    return response()->json(['loggedIn' => Auth::check()]);
});
Route::apiResource('apartments', ApartmentController::class);
