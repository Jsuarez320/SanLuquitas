<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Equivalente a require_role("admin") de SmartPark:
 * solo usuarios activos con es_admin pueden entrar al módulo.
 */
class EnsureAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        abort_unless($user && $user->activo && $user->esAdmin(), 403, 'No tienes permisos para realizar esta acción.');

        return $next($request);
    }
}
