<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Registro y gestión de usuarios. En SmartPark no hay registro público:
 * las cuentas las crea un administrador.
 */
class UserController extends Controller
{
    public function index()
    {
        return view('admin.usuarios.index', [
            'usuarios' => User::orderBy('name')->orderBy('apellido')->paginate(15),
        ]);
    }

    public function create()
    {
        return view('admin.usuarios.create');
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $datos = $request->validated();
        $datos['es_admin'] = $request->boolean('es_admin');

        User::create($datos);

        return redirect()->route('admin.usuarios.index')->with('exito', 'Usuario registrado correctamente.');
    }

    /** Activa o desactiva una cuenta (un usuario inactivo no puede iniciar sesión). */
    public function toggleActivo(Request $request, User $usuario): RedirectResponse
    {
        if ($usuario->is($request->user())) {
            return back()->with('error', 'No puedes desactivar tu propia cuenta.');
        }

        $usuario->update(['activo' => ! $usuario->activo]);

        return back()->with('exito', $usuario->activo ? 'Usuario activado.' : 'Usuario desactivado.');
    }
}
