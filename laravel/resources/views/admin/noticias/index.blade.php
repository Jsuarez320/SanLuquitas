@extends('admin.layout')

@section('title', 'Noticias y comunicados')

@php
    $campo = 'rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-800 shadow-sm transition focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary';
@endphp

@section('content')
    <div class="flex flex-wrap items-end justify-between gap-4 motion-safe:animate-fade-up">
        <div>
            <h1 class="font-heading text-3xl font-bold text-primary-dark">Noticias y comunicados</h1>
            <p class="mt-1 text-slate-500">Lo que publiques aquí se muestra en la sección Noticias del sitio.</p>
        </div>
        <a href="{{ route('admin.noticias.create') }}"
           class="inline-flex items-center gap-2 rounded-full bg-accent px-5 py-2.5 font-heading text-sm font-semibold text-primary-dark shadow-sm transition hover:-translate-y-0.5 hover:bg-accent-dark hover:shadow-md active:scale-95">
            <x-icon name="plus" class="h-4 w-4" /> Nueva publicación
        </a>
    </div>

    {{-- Filtros: se aplican al cambiar un selector o al enviar la búsqueda --}}
    <form method="GET" action="{{ route('admin.noticias.index') }}" role="search"
          class="mt-6 grid gap-3 rounded-2xl bg-white p-4 shadow-sm ring-1 ring-slate-200 motion-safe:animate-fade-up sm:grid-cols-[1fr_auto_auto_auto]"
          style="animation-delay: 80ms">
        <div class="relative">
            <label for="q" class="sr-only">Buscar por título o resumen</label>
            <x-icon name="magnifying-glass" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" />
            <input id="q" name="q" type="search" value="{{ request('q') }}" placeholder="Buscar por título o resumen"
                   class="{{ $campo }} w-full pl-9">
        </div>
        <div>
            <label for="tipo" class="sr-only">Tipo</label>
            <select id="tipo" name="tipo" onchange="this.form.requestSubmit()" class="{{ $campo }} w-full">
                <option value="">Todos los tipos</option>
                @foreach (\App\Models\Noticia::TIPOS as $valor => $etiqueta)
                    <option value="{{ $valor }}" @selected(request('tipo') === $valor)>{{ $etiqueta }}s</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="estado" class="sr-only">Estado</label>
            <select id="estado" name="estado" onchange="this.form.requestSubmit()" class="{{ $campo }} w-full">
                <option value="">Todos los estados</option>
                @foreach (\App\Models\Noticia::ESTADOS as $valor => $etiqueta)
                    <option value="{{ $valor }}" @selected(request('estado') === $valor)>{{ $etiqueta }}s</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="rounded-full bg-primary px-5 py-2.5 font-heading text-sm font-semibold text-white transition hover:bg-primary-dark active:scale-95">Buscar</button>
    </form>

    @if ($noticias->isEmpty())
        {{-- Estado vacío: qué es, por qué está vacío y cómo seguir --}}
        <div class="mt-6 rounded-2xl border-2 border-dashed border-slate-300 bg-white p-10 text-center motion-safe:animate-pop-in">
            <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-primary/10 text-primary">
                <x-icon :name="$hayFiltros ? 'magnifying-glass' : 'megaphone'" class="h-7 w-7" />
            </span>
            @if ($hayFiltros)
                <h2 class="mt-4 font-heading text-lg font-semibold text-primary-dark">No encontramos resultados</h2>
                <p class="mx-auto mt-1 max-w-sm text-slate-500">Prueba con otra búsqueda o quita los filtros para ver todas las publicaciones.</p>
                <a href="{{ route('admin.noticias.index') }}" class="mt-5 inline-flex rounded-full border-2 border-primary px-5 py-2.5 font-heading text-sm font-semibold text-primary transition hover:bg-primary hover:text-white">Quitar filtros</a>
            @else
                <h2 class="mt-4 font-heading text-lg font-semibold text-primary-dark">Aún no hay publicaciones</h2>
                <p class="mx-auto mt-1 max-w-sm text-slate-500">Crea la primera noticia o comunicado para que aparezca en el sitio.</p>
                <a href="{{ route('admin.noticias.create') }}" class="mt-5 inline-flex rounded-full bg-accent px-5 py-2.5 font-heading text-sm font-semibold text-primary-dark transition hover:bg-accent-dark">Crear publicación</a>
            @endif
        </div>
    @else
        <p class="mt-6 text-sm text-slate-500" aria-live="polite">
            {{ $noticias->total() }} {{ $noticias->total() === 1 ? 'publicación' : 'publicaciones' }}
        </p>

        <ul class="mt-3 space-y-3">
            @foreach ($noticias as $n)
                <li class="group flex flex-col gap-4 rounded-2xl bg-white p-4 shadow-sm ring-1 ring-slate-200 transition duration-300 hover:-translate-y-0.5 hover:shadow-lg hover:ring-primary/30 motion-safe:animate-fade-up sm:flex-row sm:items-center"
                    style="animation-delay: {{ 120 + $loop->index * 70 }}ms">
                    <div class="h-24 w-full shrink-0 overflow-hidden rounded-xl bg-slate-100 sm:h-20 sm:w-32">
                        <img src="{{ $n->imagen }}" alt="" loading="lazy" class="h-full w-full object-cover transition duration-500 group-hover:scale-110">
                    </div>

                    <div class="min-w-0 flex-1">
                        <div class="flex flex-wrap items-center gap-2 text-xs font-semibold">
                            <span class="rounded-full px-2.5 py-0.5 {{ $n->tipo === 'comunicado' ? 'bg-accent/25 text-primary-dark' : 'bg-primary/10 text-primary' }}">{{ \App\Models\Noticia::TIPOS[$n->tipo] }}</span>
                            <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-0.5 {{ $n->estaPublicada() ? 'bg-green-100 text-green-800' : 'bg-slate-200 text-slate-700' }}">
                                <span class="h-1.5 w-1.5 rounded-full {{ $n->estaPublicada() ? 'bg-green-600 motion-safe:animate-pulse' : 'bg-slate-500' }}"></span>
                                {{ \App\Models\Noticia::ESTADOS[$n->estado] }}
                            </span>
                            <span class="text-slate-500">{{ $n->categoria }}</span>
                        </div>
                        <h2 class="mt-1.5 truncate font-heading text-lg font-semibold text-primary-dark">
                            <a href="{{ route('admin.noticias.edit', $n) }}" class="hover:text-primary">{{ $n->titulo }}</a>
                        </h2>
                        <p class="truncate text-sm text-slate-500">{{ $n->extracto }}</p>
                        <p class="mt-1 text-xs text-slate-400"><time datetime="{{ $n->fecha }}">{{ $n->fecha_legible }}</time></p>
                    </div>

                    <div class="flex shrink-0 items-center gap-1 sm:flex-col sm:items-end lg:flex-row">
                        <form method="POST" action="{{ route('admin.noticias.estado', $n) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="rounded-full px-3 py-1.5 text-sm font-semibold text-primary transition hover:bg-primary/10 active:scale-95">
                                {{ $n->estaPublicada() ? 'Pasar a borrador' : 'Publicar' }}
                            </button>
                        </form>
                        <a href="{{ route('admin.noticias.edit', $n) }}" class="inline-flex items-center gap-1 rounded-full px-3 py-1.5 text-sm font-semibold text-primary transition hover:bg-primary/10 active:scale-95">
                            <x-icon name="pencil-square" class="h-4 w-4" /> Editar<span class="sr-only"> {{ $n->titulo }}</span>
                        </a>
                        <button type="button"
                                @click="$dispatch('confirmar-eliminar', { titulo: @js($n->titulo), url: @js(route('admin.noticias.destroy', $n)) })"
                                class="inline-flex items-center gap-1 rounded-full px-3 py-1.5 text-sm font-semibold text-red-700 transition hover:bg-red-50 active:scale-95">
                            <x-icon name="trash" class="h-4 w-4" /> Eliminar<span class="sr-only"> {{ $n->titulo }}</span>
                        </button>
                    </div>
                </li>
            @endforeach
        </ul>

        <div class="mt-6">{{ $noticias->links() }}</div>
    @endif
@endsection
