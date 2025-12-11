<?php

use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/', function () {
    return view('login.login');
})->name('login');

Route::get('/register', function () {
    return view('login.register');
})->name('register');