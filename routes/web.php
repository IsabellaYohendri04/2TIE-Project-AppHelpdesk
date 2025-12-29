<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\StaffUserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LaporController;
use App\Http\Controllers\MultipleuploadsController;

/*
|--------------------------------------------------------------------------
| GUEST
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
 /* ===============================
       LAPOR (USER)
       =============================== */
    Route::get('/', [LaporController::class, 'index'])
        ->name('lapor.index');

    Route::post('/', [LaporController::class, 'store'])
        ->name('lapor.store');

});

/*
|--------------------------------------------------------------------------
| AUTH (SEMUA USER LOGIN)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/multipleuploads', [MultipleuploadsController::class, 'index'])
        ->name('uploads');

    Route::post('/save', [MultipleuploadsController::class, 'store'])
        ->name('uploads.store');

   
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

            Route::resource('ticket', TicketController::class);
            Route::resource('staff', StaffUserController::class)
                ->parameters(['staff' => 'staff']);

            Route::get('category/{category}/staffs', [CategoryController::class, 'staffs'])
                ->name('category.staffs');

            Route::resource('category', CategoryController::class);

        });

});
