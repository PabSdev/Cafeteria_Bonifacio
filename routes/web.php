<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Rutas públicas (sin autenticación)
Route::get('/', function () {
    return view('index');
})->name('Home'); // Home no depende de AuthController

Route::get('/login', function () {
    return view('login');
})->name('login'); // Login como vista pública

// Rutas de autenticación (usando AuthController)
Route::post('/custom-login', [AuthController::class, 'login'])->name('custom-login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas privadas (requieren autenticación)
Route::middleware(['auth'])->group(function () {
    Route::get('/logados', [AuthController::class, 'logados'])->name('logados');
});
