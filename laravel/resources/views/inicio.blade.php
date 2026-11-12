@extends('layouts.app')

@section('title', 'Inicio')

@section('content')
    {{-- Hero con imagen de fondo y overlay --}}
    <section class="on-dark relative isolate overflow-hidden bg-primary-dark">
        <img src="{{ asset('images/inicio/fachada.jpg') }}" alt="" aria-hidden="true" width="1600" height="900" fetchpriority="high"
             class="absolute inset-0 -z-20 h-full w-full object-cover object-[50%_60%]">
        {{-- Degradado suave: algo más oscuro a la izquierda (donde va el texto) y casi transparente a la derecha --}}
        <div class="absolute inset-0 -z-10 bg-gradient-to-r from-primary-dark/85 from-10% via-primary-dark/50 via-55% to-primary-dark/5"></div>

        <div class="mx-auto max-w-7xl px-4 py-24 sm:px-6 sm:py-32 lg:px-8 lg:py-40">
            <p class="font-heading text-sm font-semibold uppercase tracking-widest text-accent">Colegio San Luquitas</p>
            <h1 class="mt-4 max-w-3xl font-heading text-4xl font-bold leading-tight text-white sm:text-6xl">
                Educamos para transformar
            </h1>
            <p class="mt-6 max-w-xl text-lg text-blue-100">
                Una comunidad que forma personas íntegras, con excelencia académica, valores y tecnología al servicio del aprendizaje.
            </p>
            <div class="mt-10 flex flex-col gap-4 sm:flex-row">
                <x-button :href="route('nosotros')" variant="outline-light">Conoce el colegio</x-button>
                <x-button :href="config('sanluquitas.moodle_url')" variant="accent" :external="true">
                    Ir al Campus Virtual <x-icon name="arrow-right" class="h-4 w-4" />
                </x-button>
            </div>
        </div>
    </section>

    {{-- Franja de cifras --}}
    <section class="relative z-10 mx-auto -mt-10 max-w-5xl px-4 sm:px-6 lg:px-8" aria-label="San Luquitas en cifras">
        <dl class="grid grid-cols-1 divide-y divide-slate-100 rounded-2xl bg-white shadow-xl shadow-slate-300/40 ring-1 ring-slate-100 sm:grid-cols-3 sm:divide-x sm:divide-y-0">
            @foreach (config('sanluquitas.cifras') as $cifra)
                <div class="flex flex-col items-center px-6 py-8 text-center">
                    <x-icon :name="$cifra['icono']" class="mb-2 h-7 w-7 text-primary" />
                    <dd class="order-first font-heading text-4xl font-bold text-primary-dark">{{ $cifra['valor'] }}</dd>
                    <dt class="mt-1 text-sm font-medium text-slate-600">{{ $cifra['etiqueta'] }}</dt>
                </div>
            @endforeach
        </dl>
    </section>

    {{-- Pilares --}}
    <section class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
        <x-section-title eyebrow="Nuestros pilares" title="Lo que nos define"
                         subtitle="Tres ejes que guían la experiencia educativa de cada estudiante." />
        <div class="grid gap-6 md:grid-cols-3">
            @foreach ($pilares as $pilar)
                <x-card :icon="$pilar['icono']" :title="$pilar['titulo']">{{ $pilar['texto'] }}</x-card>
            @endforeach
        </div>
    </section>

    {{-- Últimas noticias --}}
    <section class="bg-slate-50 py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <x-section-title eyebrow="Noticias" title="Lo último en San Luquitas" />
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($noticias as $noticia)
                    <x-news-card :noticia="$noticia" />
                @endforeach
            </div>
            <div class="mt-10 text-center">
                <x-button :href="route('noticias.index')" variant="outline">Ver todas las noticias</x-button>
            </div>
        </div>
    </section>

    {{-- Banner final: Campus Virtual --}}
    <section class="on-dark bg-primary-dark">
        <div class="mx-auto flex max-w-7xl flex-col items-center gap-6 px-4 py-16 text-center sm:px-6 lg:flex-row lg:justify-between lg:px-8 lg:text-left">
            <div class="max-w-2xl">
                <h2 class="font-heading text-3xl font-bold text-white">Tu aula, también en línea</h2>
                <p class="mt-3 text-lg text-blue-100">Ingresa al Campus Virtual para acceder a tus cursos, actividades y recursos desde cualquier lugar.</p>
            </div>
            <x-button :href="config('sanluquitas.moodle_url')" variant="accent" :external="true" class="shrink-0">
                Entrar al Campus Virtual <x-icon name="arrow-right" class="h-4 w-4" />
            </x-button>
        </div>
    </section>
@endsection
