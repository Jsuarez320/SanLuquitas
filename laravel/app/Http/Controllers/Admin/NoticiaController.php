<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NoticiaRequest;
use App\Models\Noticia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/** Registro, consulta, actualización y eliminación de noticias y comunicados. */
class NoticiaController extends Controller
{
    public function index(Request $request)
    {
        $noticias = Noticia::query()
            ->when($request->filled('q'), function ($q) use ($request) {
                $buscar = '%'.mb_strtolower($request->string('q')->trim()).'%';
                $q->where(fn ($w) => $w->whereRaw('lower(titulo) like ?', [$buscar])->orWhereRaw('lower(extracto) like ?', [$buscar]));
            })
            ->when(array_key_exists($request->input('tipo'), Noticia::TIPOS), fn ($q) => $q->where('tipo', $request->input('tipo')))
            ->when(array_key_exists($request->input('estado'), Noticia::ESTADOS), fn ($q) => $q->where('estado', $request->input('estado')))
            ->orderByDesc('publicada_en')
            ->orderByDesc('id')
            ->paginate(8)
            ->withQueryString();

        return view('admin.noticias.index', [
            'noticias' => $noticias,
            'hayFiltros' => $request->filled('q') || $request->filled('tipo') || $request->filled('estado'),
        ]);
    }

    public function create()
    {
        return view('admin.noticias.create', [
            'noticia' => new Noticia(['tipo' => 'noticia', 'estado' => 'borrador', 'publicada_en' => now()]),
        ]);
    }

    public function store(NoticiaRequest $request): RedirectResponse
    {
        $datos = $request->safe()->except(['imagen', 'quitar_imagen']);
        $datos['user_id'] = $request->user()->id;

        if ($request->hasFile('imagen')) {
            $datos['imagen_path'] = $request->file('imagen')->store('noticias', 'public');
        }

        $noticia = Noticia::create($datos);

        return redirect()->route('admin.noticias.index')
            ->with('exito', "«{$noticia->titulo}» se guardó como ".strtolower(Noticia::ESTADOS[$noticia->estado]).'.');
    }

    public function edit(Noticia $noticia)
    {
        return view('admin.noticias.edit', compact('noticia'));
    }

    public function update(NoticiaRequest $request, Noticia $noticia): RedirectResponse
    {
        $datos = $request->safe()->except(['imagen', 'quitar_imagen']);

        if ($request->hasFile('imagen')) {
            $this->borrarImagen($noticia);
            $datos['imagen_path'] = $request->file('imagen')->store('noticias', 'public');
        } elseif ($request->boolean('quitar_imagen')) {
            $this->borrarImagen($noticia);
            $datos['imagen_path'] = null;
        }

        $noticia->update($datos);

        return redirect()->route('admin.noticias.index')->with('exito', 'Cambios guardados.');
    }

    /** Publica o pasa a borrador (sin abrir el formulario). */
    public function toggleEstado(Noticia $noticia): RedirectResponse
    {
        $noticia->update(['estado' => $noticia->estaPublicada() ? 'borrador' : 'publicado']);

        return back()->with('exito', $noticia->estaPublicada()
            ? "«{$noticia->titulo}» ya está publicada."
            : "«{$noticia->titulo}» volvió a borrador y dejó de verse en el sitio.");
    }

    public function destroy(Noticia $noticia): RedirectResponse
    {
        $this->borrarImagen($noticia);
        $noticia->delete();

        return redirect()->route('admin.noticias.index')->with('exito', "«{$noticia->titulo}» se eliminó.");
    }

    private function borrarImagen(Noticia $noticia): void
    {
        if ($noticia->imagen_path) {
            Storage::disk('public')->delete($noticia->imagen_path);
        }
    }
}
