<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Función que muestra la vista de logados o la vista con el formulario de Login
     */
    public function index()
    {
        // Comprobamos si el usuario ya está logado
        if (Auth::check()) {

            // Si está logado le mostramos la vista de logados
            return view('logados');
        }

        // Si no está logado le mostramos la vista con el formulario de login
        return view('login');
    }

    /**
     * Función que se encarga de recibir los datos del formulario de login, comprobar que el usuario existe y
     * en caso correcto logar al usuario
     */
// app/Http/Controllers/AuthController.php
    // app/Http/Controllers/AuthController.php
    public function login(Request $request)
    {
        // Validate the request data
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to log the user in with the remember option
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            // Authentication passed...
            $user = Auth::user();

            // Check the user's role and redirect accordingly
            if ($user->rol == 1) {
                // Redirect to admin dashboard
                return redirect()->intended('admin/dashboard');
            } else {
                // Redirect to user dashboard
                return redirect()->intended('user/dashboard');
            }
        }

        // Authentication failed...
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    /**
     * Función que muestra la vista de logados si el usuario está logado y si no le devuelve al formulario de login
     * con un mensaje de error
     */
    public function logados()
    {
        if (Auth::check()) {
            return view('logados');
        }

        return redirect("/")->withSuccess('No tienes acceso, por favor inicia sesión');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate(); // Invalida la sesión actual
        $request->session()->regenerateToken(); // Regenera el token CSRF para seguridad

        return redirect('/')->with('success', 'Has cerrado sesión correctamente.');
    }

    public function showLoginForm()
    {
        return view('login');
    }
}
