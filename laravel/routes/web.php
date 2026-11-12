<?php

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
