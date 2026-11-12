@extends('layouts.app')

@section('title', 'Oferta académica')

@section('content')
    <section class="on-dark bg-primary-dark py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h1 class="font-heading text-4xl font-bold text-white sm:text-5xl">Oferta académica</h1>
            <p class="mt-3 max-w-2xl text-lg text-blue-100">Un recorrido formativo completo, desde los primeros años hasta la preparación para la universidad.</p>
        </div>
    </section>

    {{-- Niveles (tabs con Alpine.js) --}}
    <section class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8" x-data="{ tab: '{{ $niveles[0]['id'] }}' }">
        <x-section-title eyebrow="Niveles" title="Elige un nivel para conocerlo" />

        <div role="tablist" aria-label="Niveles académicos" class="mb-8 flex flex-wrap justify-center gap-2">
            @foreach ($niveles as $nivel)
                <button type="button" role="tab" id="tab-{{ $nivel['id'] }}" aria-controls="panel-{{ $nivel['id'] }}"
                        :aria-selected="tab === '{{ $nivel['id'] }}'" @click="tab = '{{ $nivel['id'] }}'"
                        :class="tab === '{{ $nivel['id'] }}' ? 'bg-primary text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'"
                        class="rounded-full px-6 py-2.5 font-heading text-sm font-semibold transition">
                    {{ $nivel['nombre'] }}
                </button>
            @endforeach
        </div>

        @foreach ($niveles as $nivel)
            <div role="tabpanel" id="panel-{{ $nivel['id'] }}" aria-labelledby="tab-{{ $nivel['id'] }}"
                 x-show="tab === '{{ $nivel['id'] }}'" @if (! $loop->first) x-cloak @endif
                 class="mx-auto max-w-3xl rounded-2xl bg-white p-8 shadow-md shadow-slate-200/60 ring-1 ring-slate-100">
                <h3 class="font-heading text-2xl font-bold text-primary-dark">{{ $nivel['nombre'] }}</h3>
                <p class="mt-1 text-sm font-medium text-primary">{{ $nivel['grados'] }}</p>
                <p class="mt-4 leading-relaxed">{{ $nivel['descripcion'] }}</p>
                <ul class="mt-6 space-y-3">
                    @foreach ($nivel['puntos'] as $punto)
                        <li class="flex gap-3"><x-icon name="check-circle" class="h-6 w-6 shrink-0 text-primary" />{{ $punto }}</li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </section>

    {{-- Cursos virtuales en Moodle --}}
    <section class="bg-slate-50 py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <x-section-title eyebrow="Campus Virtual" title="Cursos virtuales disponibles"
                             subtitle="Complementa tu aprendizaje en nuestra plataforma Moodle." />
            <div class="grid gap-6 md:grid-cols-3">
                @foreach ($cursos as $curso)
                    <x-card :icon="$curso['icono']" :title="$curso['titulo']">
                        <span class="mb-2 inline-block rounded-full bg-accent/20 px-3 py-1 text-xs font-semibold text-primary-dark">{{ $curso['nivel'] }}</span>
                        <p>{{ $curso['texto'] }}</p>
                    </x-card>
                @endforeach
            </div>
            <div class="mt-10 text-center">
                <x-button :href="config('sanluquitas.moodle_url')" variant="accent" :external="true">
                    Ir al Campus Virtual <x-icon name="arrow-right" class="h-4 w-4" />
                </x-button>
            </div>
        </div>
    </section>
@endsection
