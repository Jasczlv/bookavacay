<?php

use App\Http\Controllers\Admin\ApartmentController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SponsorController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])
    ->name('admin.')
    ->prefix('admin')
    ->group(function () {

        Route::get('/', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        // search request routes 
        Route::get('users/search', [UserController::class, 'search'])->name('users.search');
        Route::get('apartments/search', [ApartmentController::class, 'search'])->name('apartments.search');

        // custom pages routes
        Route::get('apartments/sponsors', [ApartmentController::class, 'sponsors'])->name('apartments.sponsors');
        Route::put('apartments/new_sponsor', [ApartmentController::class, 'new_sponsor'])->name('apartments.new_sponsor');
        Route::get('apartments/{apartment}/generate-client-token', [ApartmentController::class, 'generateClientToken'])->name('apartments.generate-client-token');
        Route::get('apartments/{apartment}/statistics', [ApartmentController::class, 'statistics'])->name('apartments.statistics');
        Route::get('apartments/{apartment}/messages', [ApartmentController::class, 'messages'])->name('apartments.messages');

        //register all other protected routes
        Route::resource('apartments', ApartmentController::class);
        /* 
                Route::resource('users', UserController::class);
                Route::resource('sponsors', SponsorController::class);
                Route::resource('services', ServiceController::class); */
    });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('register/user', [UserController::class, 'store'])->name('user.register.store');

require __DIR__ . '/auth.php';
