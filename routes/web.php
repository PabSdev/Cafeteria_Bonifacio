<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\OrderController;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Log;

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

Route::get('/auth/google', function () {
    return Socialite::driver('google')->redirect();
})->name('auth.google');

Route::get('/auth/google/callback', function () {
    try {
        $googleUser = Socialite::driver('google')->user();
        $user = \App\Models\User::where('email', $googleUser->getEmail())->first();
        if ($user) {
            // Si el usuario ya existe, inicie sesión
            \Illuminate\Support\Facades\Auth::login($user);
        } else {
            // Si el usuario no existe, regístrelo
            $user = \App\Models\User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'password' => bcrypt(\Illuminate\Support\Str::random(16)), // Genera una contraseña aleatoria
            ]);
            \Illuminate\Support\Facades\Auth::login($user);
        }
        return redirect()->route('logados'); // Redirigir a la ruta 'logados'
    } catch (\Exception $e) {
        // Manejar la excepción y redirigir al usuario a una página de error
        Log::error('Google authentication error: ' . $e->getMessage());
        return redirect()->route('login')->with('error', 'Error al autenticar con Google.');
    }
});

// Rutas de compras
Route::get('/shopping', [ProductsController::class, 'shopping'])->name('shopping');

// Rutas de autenticación (usando AuthController)
Route::post('/custom-login', [AuthController::class, 'login'])->name('custom-login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logados', [AuthController::class, 'logados'])->name('logados');

// Rutas de usuarios (usando UserController)
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');

// Rutas de productos (usando ProductsController)
Route::get('/products/create', [ProductsController::class, 'create'])->name('products.create');
Route::post('/products', [ProductsController::class, 'store'])->name('products.store');
Route::delete('/products/{id}', [ProductsController::class, 'destroy'])->name('products.destroy');
Route::get('/products/{id}/edit', [ProductsController::class, 'edit'])->name('products.edit');
Route::put('/products/{id}', [ProductsController::class, 'update'])->name('products.update');

Route::get('/menu', [ProductsController::class, 'showMenu'])->name('menu');

Route::post('/api/create-payment-intent', [StripeController::class, 'createPaymentIntent']);

Route::get('/kitchen/orders', [OrderController::class, 'kitchen'])->name('kitchen.orders');
Route::get('/order/confirmation/{id}', [OrderController::class, 'confirmation'])->name('user.confirmation');
Route::put('/order/update/{id}', [OrderController::class, 'update'])->name('order.update');
Route::post('/order/create', [OrderController::class, 'create'])->name('order.create');
// Rutas privadas (requieren autenticación)
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin');
    Route::get('/user/dashboard', [UserController::class, 'index'])->name('user');
});
