@extends('layouts.app')

@section('title', 'Página no encontrada')

@section('content')
    <section class="mx-auto flex min-h-[60vh] max-w-2xl flex-col items-center justify-center px-4 py-24 text-center">
        <p class="font-heading text-8xl font-bold text-primary">404</p>
        <h1 class="mt-4 font-heading text-3xl font-bold text-primary-dark">Página no encontrada</h1>
        <p class="mt-3 text-lg text-slate-600">Lo sentimos, la página que buscas no existe o fue movida.</p>
        <div class="mt-8 flex flex-col gap-4 sm:flex-row">
            <x-button :href="route('inicio')" variant="primary">Volver al inicio</x-button>
            <x-button :href="config('sanluquitas.moodle_url')" variant="accent" :external="true">Ir al Campus Virtual</x-button>
        </div>
    </section>
@endsection
