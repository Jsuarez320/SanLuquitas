<?php

namespace App\Http\Controllers;

use App\Models\Noticia;

/**
 * Noticias del colegio (sitio público). Solo muestra las publicadas;
 * se administran desde /admin/noticias.
 */
class NewsController extends Controller
{
    /**
     * Noticias publicadas, de la más reciente a la más antigua.
     * También las usa PageController para mostrar las últimas 3 en el inicio.
     *
     * @return array<int, Noticia>
     */
    public static function articulos(): array
    {
        return Noticia::publicadas()->get()->all();
    }

    /** Listado de noticias. */
    public function index()
    {
        return view('noticias.index', ['noticias' => self::articulos()]);
    }

    /** Detalle de una noticia por slug (404 si no existe o no está publicada). */
    public function show(string $slug)
    {
        $noticia = Noticia::publicadas()->where('slug', $slug)->firstOrFail();

        // Otras noticias sugeridas (excluye la actual).
        $relacionadas = Noticia::publicadas()->whereKeyNot($noticia->id)->limit(3)->get()->all();

        return view('noticias.show', compact('noticia', 'relacionadas'));
    }
}
