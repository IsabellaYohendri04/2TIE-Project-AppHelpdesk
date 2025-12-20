<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\StaffUserController;
use App\Http\Controllers\MultipleuploadsController;

/*
|--------------------------------------------------------------------------
| GUEST (BELUM LOGIN)/tidak login
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {

    Route::get('/', function () {
        return view('welcome');
    })->name('welcome');

    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.process');
});

/*
|--------------------------------------------------------------------------
| AUTH (SUDAH LOGIN)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // LOGOUT (POST)
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    // DASHBOARD UMUM (SEMUA ROLE MASUK SINI DULU)
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

   Route::get('/multipleuploads', [MultipleuploadsController::class, 'index'])->name('uploads');
   Route::post('/save', [MultipleuploadsController::class, 'store'])->name('uploads.store');


    /*
    |--------------------------------------------------------------------------
    | ADMIN ONLY
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            Route::get('/dashboard', function () {
                return view('dashboard');
            })->name('dashboard');

            // CRUD Tiket Helpdesk IT (khusus Admin)
            Route::resource('ticket', TicketController::class);

            // Manajemen User Staf Helpdesk (khusus Admin)
            Route::resource('staff', StaffUserController::class)
                ->parameters(['staff' => 'staff']);
        });

});
