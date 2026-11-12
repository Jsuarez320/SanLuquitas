@extends('layouts.app')

@section('title', 'Noticias')

@section('content')
    <section class="on-dark bg-primary-dark py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h1 class="font-heading text-4xl font-bold text-white sm:text-5xl">Noticias</h1>
            <p class="mt-3 max-w-2xl text-lg text-blue-100">Lo que pasa en nuestra comunidad educativa.</p>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($noticias as $noticia)
                <x-news-card :noticia="$noticia" />
            @endforeach
        </div>
    </section>
@endsection
