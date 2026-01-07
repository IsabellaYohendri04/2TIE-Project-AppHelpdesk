<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporController;
use App\Http\Controllers\MultipleuploadsController;
use App\Http\Controllers\StaffUserController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

// Login
Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

/*
|--------------------------------------------------------------------------
| GUEST
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
   
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

    // Profile Settings
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::put('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile/picture', [\App\Http\Controllers\ProfileController::class, 'destroyPicture'])
        ->name('profile.picture.destroy');

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

    /*
    |--------------------------------------------------------------------------
    | STAFF ONLY
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:staff')
        ->prefix('staff')
        ->name('staff.')
        ->group(function () {

            Route::get('ticket', [TicketController::class, 'staffIndex'])
                ->name('ticket.index');
            Route::get('ticket/assigned', [TicketController::class, 'staffAssigned'])
                ->name('ticket.assigned');
            Route::get('ticket/create', [TicketController::class, 'staffCreate'])
                ->name('ticket.create');
            Route::post('ticket', [TicketController::class, 'staffStore'])
                ->name('ticket.store');
            Route::get('ticket/{ticket}/edit', [TicketController::class, 'staffEdit'])
                ->name('ticket.edit');
            Route::put('ticket/{ticket}', [TicketController::class, 'staffUpdate'])
                ->name('ticket.update');

        });

});


Route::post('/logout-to-lapor', function () {
    session(['redirect_after_logout' => route('lapor.index')]);
    return redirect()->route('logout');
})->name('logout.to.lapor');
