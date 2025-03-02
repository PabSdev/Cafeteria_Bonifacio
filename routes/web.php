<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

// Rutas públicas (sin autenticación)
Route::get('/', function () {
    return view('index');
})->name('Home'); // Home no depende de AuthController

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/admin/dashboard', function () {
    return view('private.dashboard');
});

// Rutas de autenticación (usando AuthController)
Route::post('/custom-login', [AuthController::class, 'login'])->name('custom-login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Rutas privadas (requieren autenticación)
// routes/web.php
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin');
    Route::get('/user/dashboard', [UserController::class, 'index'])->name('user');
});
