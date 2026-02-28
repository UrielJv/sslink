<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Mostrar formulario de login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Procesar login
    public function login(Request $request)
    {
        // Validar datos
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Intentar login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Redirección por rol (prioridad)
            if ($user->hasRole('admin')) {
                return redirect()->route('dashboard');
            }

            if ($user->hasRole('encargado')) {
                return redirect()->route('asistencias.index');
            }

            if ($user->hasRole('estudiante')) {
                return redirect()->route('estudiante.info');
            }

            // Si por alguna razón no tiene rol
            Auth::logout();
            return redirect()->route('login')
                ->withErrors(['email' => 'Tu cuenta no tiene rol asignado.']);
        }

        // Si falla
        return back()->withErrors([
            'email' => 'Las credenciales no son correctas',
        ])->onlyInput('email');
    }

    // Cerrar sesión
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
