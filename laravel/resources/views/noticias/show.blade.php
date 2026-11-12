@extends('layouts.app')

@section('title', $noticia['titulo'])
@section('description', $noticia['extracto'])

@section('content')
    <article class="mx-auto max-w-3xl px-4 py-16 sm:px-6 lg:px-8">
        <a href="{{ route('noticias.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-primary hover:text-primary-dark">
            <x-icon name="arrow-left" class="h-4 w-4" /> Volver a noticias
        </a>

        <div class="mt-6 flex items-center gap-3 text-sm">
            <span class="rounded-full bg-accent/20 px-3 py-1 font-medium text-primary-dark">{{ $noticia['categoria'] }}</span>
            <time datetime="{{ $noticia['fecha'] }}" class="text-slate-600">{{ $noticia['fecha_legible'] }}</time>
        </div>
        <h1 class="mt-4 font-heading text-3xl font-bold text-primary-dark sm:text-4xl">{{ $noticia['titulo'] }}</h1>

        <img src="{{ $noticia['imagen'] }}" alt="Imagen de la noticia: {{ $noticia['titulo'] }}"
             class="mt-8 aspect-[16/10] w-full rounded-2xl object-cover shadow-lg">

        <div class="mt-8 space-y-5 text-lg leading-relaxed">
            @foreach ($noticia['contenido'] as $parrafo)
                <p>{{ $parrafo }}</p>
            @endforeach
        </div>
    </article>

    {{-- Más noticias --}}
    <section class="bg-slate-50 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <x-section-title title="Más noticias" />
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($relacionadas as $item)
                    <x-news-card :noticia="$item" />
                @endforeach
            </div>
        </div>
    </section>
@endsection
