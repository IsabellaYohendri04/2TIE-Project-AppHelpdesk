<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| GUEST (belum login)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {

    // Halaman login
    Route::get('/auth', [AuthController::class, 'index'])->name('login');

    // Proses login
    Route::post('/auth/login', [AuthController::class, 'login'])->name('login.process');

    // Landing page
    Route::get('/', function () {
        return view('welcome');
    });

});

/*
|--------------------------------------------------------------------------
| AUTH (sudah login)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard USER BIASA
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Home alternatif (opsional)
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    /*
    |--------------------------------------------------------------------------
    | ADMIN ONLY
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {

        Route::get('/dashboard', function () {
            return view('dashboard.admin');
        })->name('dashboard');

        Route::resource('user', UserController::class);
        Route::resource('pelanggan', PelangganController::class);

    });

});
