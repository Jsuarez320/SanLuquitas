@extends('layouts.app')

@section('title', 'Nosotros')

@section('content')
    {{-- Encabezado de página --}}
    <section class="on-dark bg-primary-dark py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h1 class="font-heading text-4xl font-bold text-white sm:text-5xl">Nosotros</h1>
            <p class="mt-3 max-w-2xl text-lg text-blue-100">Cuatro décadas formando personas para transformar su entorno.</p>
        </div>
    </section>

    {{-- Historia --}}
    <section class="mx-auto grid max-w-7xl items-center gap-10 px-4 py-20 sm:px-6 lg:grid-cols-2 lg:px-8">
        <div>
            <x-section-title align="left" eyebrow="Nuestra historia" title="Una tradición que sigue creciendo" class="!mb-6" />
            <div class="space-y-4 leading-relaxed">
                <p>El Colegio San Luquitas nació hace 40 años con un sueño sencillo: ofrecer a las familias de la ciudad una educación de calidad, cercana y basada en valores.</p>
                <p>Desde entonces hemos crecido junto a miles de estudiantes, incorporando nuevas metodologías y, más recientemente, un campus virtual que extiende el aprendizaje más allá del aula.</p>
                <p>Hoy seguimos fieles a nuestra esencia: acompañar a cada niño y joven para que descubra y desarrolle todo su potencial.</p>
            </div>
        </div>
        <img src="https://placehold.co/800x600/E2E8F0/1E5AA8?text=Nuestra+historia" alt="Fachada del colegio y estudiantes en el patio"
             class="w-full rounded-2xl object-cover shadow-lg" loading="lazy">
    </section>

    {{-- Misión, visión y valores --}}
    <section class="bg-slate-50 py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <x-section-title eyebrow="Identidad" title="Misión, visión y valores" />
            <div class="grid gap-6 md:grid-cols-2">
                <x-card icon="flag" title="Misión">
                    Formar integralmente a niños y jóvenes, con excelencia académica y sólidos valores, para que contribuyan positivamente a la sociedad.
                </x-card>
                <x-card icon="eye" title="Visión">
                    Ser en 2030 una institución reconocida por su innovación pedagógica, su calidez humana y el uso responsable de la tecnología.
                </x-card>
            </div>
            <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($valores as $valor)
                    <x-card :icon="$valor['icono']" :title="$valor['titulo']">{{ $valor['texto'] }}</x-card>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Equipo directivo --}}
    <section class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
        <x-section-title eyebrow="Equipo" title="Equipo directivo" subtitle="Las personas que lideran nuestra comunidad educativa." />
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($directivos as $directivo)
                <div class="overflow-hidden rounded-2xl bg-white text-center shadow-md shadow-slate-200/60 ring-1 ring-slate-100">
                    <img src="https://placehold.co/400x400/E2E8F0/1E5AA8?text=Foto" alt="Fotografía de {{ $directivo['nombre'] }}"
                         class="aspect-square w-full object-cover" loading="lazy">
                    <div class="p-5">
                        <h3 class="font-heading text-lg font-semibold text-primary-dark">{{ $directivo['nombre'] }}</h3>
                        <p class="text-sm text-slate-600">{{ $directivo['cargo'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection
