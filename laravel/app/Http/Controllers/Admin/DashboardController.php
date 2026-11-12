<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalUsuarios' => User::count(),
            'totalAdmins' => User::where('es_admin', true)->count(),
            'totalInactivos' => User::where('activo', false)->count(),
        ]);
    }
}
