@extends('admin.layout')

@section('title', 'Nueva publicación')

@section('content')
    <a href="{{ route('admin.noticias.index') }}" class="inline-flex items-center gap-1 text-sm font-semibold text-primary transition hover:gap-2 hover:underline">
        <x-icon name="arrow-left" class="h-4 w-4" /> Volver a noticias
    </a>
    <h1 class="mt-2 font-heading text-3xl font-bold text-primary-dark">Nueva publicación</h1>

    @include('admin.noticias._form', [
        'accion' => route('admin.noticias.store'),
        'metodo' => 'POST',
        'boton' => 'Guardar publicación',
    ])
@endsection
