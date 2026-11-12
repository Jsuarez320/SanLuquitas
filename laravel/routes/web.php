<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\NoticiaController as AdminNoticiaController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

// Páginas institucionales
Route::get('/', [PageController::class, 'inicio'])->name('inicio');
Route::get('/nosotros', [PageController::class, 'nosotros'])->name('nosotros');
Route::get('/oferta', [PageController::class, 'oferta'])->name('oferta');

// Contacto (formulario + envío)
Route::get('/contacto', [PageController::class, 'contacto'])->name('contacto');
Route::post('/contacto', [PageController::class, 'enviarContacto'])->name('contacto.enviar');

// Noticias
Route::get('/noticias', [NewsController::class, 'index'])->name('noticias.index');
Route::get('/noticias/{slug}', [NewsController::class, 'show'])->name('noticias.show');

/*
| Módulo de administración (login portado de SmartPark Pro).
*/
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login'])->middleware('throttle:admin-login')->name('login.enviar');
    });

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

        Route::get('/usuarios', [AdminUserController::class, 'index'])->name('usuarios.index');
        Route::get('/usuarios/crear', [AdminUserController::class, 'create'])->name('usuarios.create');
        Route::post('/usuarios', [AdminUserController::class, 'store'])->name('usuarios.store');
        Route::patch('/usuarios/{usuario}/activo', [AdminUserController::class, 'toggleActivo'])->name('usuarios.activo');

        Route::resource('noticias', AdminNoticiaController::class)->except('show');
        Route::patch('/noticias/{noticia}/estado', [AdminNoticiaController::class, 'toggleEstado'])->name('noticias.estado');
    });
});
