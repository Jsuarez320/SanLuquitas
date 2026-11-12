<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

/**
 * Login/logout del módulo de administración (port de /auth/login y /auth/logout de SmartPark).
 * Usa sesión de Laravel en lugar de JWT + refresh tokens.
 */
class AuthController extends Controller
{
    public function showLogin(): mixed
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'username.required' => 'Ingrese su usuario.',
            'password.required' => 'Ingrese su contraseña.',
        ]);

        // Solo usuarios activos pueden autenticarse; el mensaje de error es genérico a propósito.
        $autenticado = Auth::attempt(
            ['username' => $datos['username'], 'password' => $datos['password'], 'activo' => true],
            $request->boolean('recordar'),
        );

        if (! $autenticado) {
            throw ValidationException::withMessages([
                'username' => 'Usuario o contraseña incorrectos.',
            ]);
        }

        $request->session()->regenerate();
        $request->user()->forceFill(['ultimo_login' => now()])->save();

        return redirect()->intended(route('admin.dashboard'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('inicio');
    }
}
