@extends('admin.layout')

@section('title', 'Panel')

@php
    $tarjetas = [
        ['Publicadas', $totalPublicadas, 'newspaper', 'bg-green-100 text-green-700', route('admin.noticias.index', ['estado' => 'publicado'])],
        ['Borradores', $totalBorradores, 'pencil-square', 'bg-slate-200 text-slate-600', route('admin.noticias.index', ['estado' => 'borrador'])],
        ['Comunicados', $totalComunicados, 'megaphone', 'bg-accent/25 text-accent-dark', route('admin.noticias.index', ['tipo' => 'comunicado'])],
        ['Usuarios', $totalUsuarios, 'users', 'bg-primary/10 text-primary', route('admin.usuarios.index')],
    ];
@endphp

@section('content')
    <div class="motion-safe:animate-fade-up">
        <h1 class="font-heading text-3xl font-bold text-primary-dark">Hola, {{ auth()->user()->name }}</h1>
        <p class="mt-1 text-slate-500">Esto es lo que hay hoy en el sitio.</p>
    </div>

    <div class="mt-8 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        @foreach ($tarjetas as [$etiqueta, $valor, $icono, $color, $enlace])
            <a href="{{ $enlace }}"
               class="group flex items-center gap-4 rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200 transition duration-300 hover:-translate-y-1 hover:shadow-lg hover:ring-primary/30 motion-safe:animate-fade-up"
               style="animation-delay: {{ 80 + $loop->index * 90 }}ms">
                <span class="flex h-12 w-12 items-center justify-center rounded-xl transition duration-300 group-hover:rotate-6 group-hover:scale-110 {{ $color }}">
                    <x-icon :name="$icono" class="h-6 w-6" />
                </span>
                <div>
                    {{-- Cuenta de 0 al valor; con "reducir movimiento" muestra el número directo --}}
                    <p class="font-heading text-2xl font-bold tabular-nums text-primary-dark"
                       x-data="{ n: 0 }"
                       x-init="const t = {{ (int) $valor }};
                               if (t === 0 || matchMedia('(prefers-reduced-motion: reduce)').matches) { n = t; return }
                               const ini = performance.now();
                               const paso = (ahora) => { const p = Math.min((ahora - ini) / 900, 1); n = Math.round(t * (1 - Math.pow(1 - p, 3))); if (p < 1) requestAnimationFrame(paso) };
                               requestAnimationFrame(paso)"
                       x-text="n">{{ $valor }}</p>
                    <p class="text-sm text-slate-500">{{ $etiqueta }}</p>
                </div>
            </a>
        @endforeach
    </div>

    <div class="mt-8 grid gap-6 lg:grid-cols-[1fr_20rem]">
        <section class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200 motion-safe:animate-fade-up" style="animation-delay: 450ms" aria-labelledby="recientes-titulo">
            <div class="flex items-center justify-between">
                <h2 id="recientes-titulo" class="font-heading text-lg font-semibold text-primary-dark">Últimas publicaciones</h2>
                <a href="{{ route('admin.noticias.index') }}" class="text-sm font-semibold text-primary hover:underline">Ver todas</a>
            </div>

            @forelse ($recientes as $n)
                <a href="{{ route('admin.noticias.edit', $n) }}"
                   class="-mx-2 mt-1 flex items-center gap-3 rounded-xl px-2 py-3 transition hover:bg-slate-50">
                    <span class="h-2.5 w-2.5 shrink-0 rounded-full {{ $n->estaPublicada() ? 'bg-green-500' : 'bg-slate-400' }}" title="{{ \App\Models\Noticia::ESTADOS[$n->estado] }}"></span>
                    <span class="min-w-0 flex-1">
                        <span class="block truncate font-medium text-primary-dark">{{ $n->titulo }}</span>
                        <span class="block text-xs text-slate-500">{{ \App\Models\Noticia::TIPOS[$n->tipo] }} · {{ \App\Models\Noticia::ESTADOS[$n->estado] }} · {{ $n->updated_at->diffForHumans() }}</span>
                    </span>
                    <x-icon name="arrow-right" class="h-4 w-4 shrink-0 text-slate-400" />
                </a>
            @empty
                <p class="mt-4 text-slate-500">Todavía no hay publicaciones. Crea la primera desde el botón de la derecha.</p>
            @endforelse
        </section>

        <section class="rounded-2xl bg-primary-dark p-6 text-white shadow-sm motion-safe:animate-fade-up" style="animation-delay: 540ms">
            <h2 class="font-heading text-lg font-semibold">Accesos rápidos</h2>
            <div class="on-dark mt-4 flex flex-col gap-3">
                <a href="{{ route('admin.noticias.create') }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-accent px-5 py-2.5 font-heading text-sm font-semibold text-primary-dark transition hover:-translate-y-0.5 hover:bg-accent-dark active:scale-95">
                    <x-icon name="plus" class="h-4 w-4" /> Nueva publicación
                </a>
                <a href="{{ route('admin.usuarios.create') }}" class="inline-flex items-center justify-center gap-2 rounded-full border-2 border-white/60 px-5 py-2.5 font-heading text-sm font-semibold text-white transition hover:bg-white hover:text-primary-dark active:scale-95">
                    <x-icon name="users" class="h-4 w-4" /> Registrar usuario
                </a>
                <a href="{{ route('noticias.index') }}" target="_blank" rel="noopener" class="inline-flex items-center justify-center gap-1 text-sm font-semibold text-blue-100 hover:text-white">
                    Ver noticias en el sitio <x-icon name="arrow-top-right" class="h-4 w-4" /><span class="sr-only">(se abre en una pestaña nueva)</span>
                </a>
            </div>
        </section>
    </div>
@endsection
