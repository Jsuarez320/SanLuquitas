@extends('admin.layout')

@section('title', 'Editar publicación')

@section('content')
    <a href="{{ route('admin.noticias.index') }}" class="inline-flex items-center gap-1 text-sm font-semibold text-primary transition hover:gap-2 hover:underline">
        <x-icon name="arrow-left" class="h-4 w-4" /> Volver a noticias
    </a>
    <div class="mt-2 flex flex-wrap items-center justify-between gap-3">
        <h1 class="font-heading text-3xl font-bold text-primary-dark">Editar publicación</h1>
        @if ($noticia->estaPublicada())
            <a href="{{ route('noticias.show', $noticia->slug) }}" target="_blank" rel="noopener"
               class="inline-flex items-center gap-1 text-sm font-semibold text-primary hover:underline">
                Ver en el sitio <x-icon name="arrow-top-right" class="h-4 w-4" /><span class="sr-only">(se abre en una pestaña nueva)</span>
            </a>
        @endif
    </div>

    @include('admin.noticias._form', [
        'accion' => route('admin.noticias.update', $noticia),
        'metodo' => 'PUT',
        'boton' => 'Guardar cambios',
    ])
@endsection
