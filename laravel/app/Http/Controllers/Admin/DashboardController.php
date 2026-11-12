<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Noticia;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalUsuarios' => User::count(),
            'totalAdmins' => User::where('es_admin', true)->count(),
            'totalPublicadas' => Noticia::where('estado', 'publicado')->count(),
            'totalBorradores' => Noticia::where('estado', 'borrador')->count(),
            'totalComunicados' => Noticia::where('tipo', 'comunicado')->count(),
            'recientes' => Noticia::latest('updated_at')->limit(5)->get(),
        ]);
    }
}
