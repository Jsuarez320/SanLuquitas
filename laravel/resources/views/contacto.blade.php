@extends('layouts.app')

@section('title', 'Contacto')

@php
    $contacto = config('sanluquitas.contacto');
    // Clases comunes de los campos del formulario.
    $campo = 'mt-1 block w-full rounded-xl border border-slate-300 px-4 py-3 text-slate-800 shadow-sm focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary';
@endphp

@section('content')
    <section class="on-dark bg-primary-dark py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h1 class="font-heading text-4xl font-bold text-white sm:text-5xl">Contacto</h1>
            <p class="mt-3 max-w-2xl text-lg text-blue-100">¿Tienes preguntas sobre admisiones o el colegio? Escríbenos.</p>
        </div>
    </section>

    <section class="mx-auto grid max-w-7xl gap-10 px-4 py-20 sm:px-6 lg:grid-cols-2 lg:px-8">
        {{-- Formulario --}}
        <div>
            @if (session('exito'))
                <div role="status" class="mb-6 flex gap-3 rounded-2xl bg-green-50 p-4 text-green-900 ring-1 ring-green-200">
                    <x-icon name="check-circle" class="h-6 w-6 shrink-0" />
                    <p>{{ session('exito') }}</p>
                </div>
            @endif

            <form method="POST" action="{{ route('contacto.enviar') }}" novalidate
                  class="space-y-5 rounded-2xl bg-white p-6 shadow-md shadow-slate-200/60 ring-1 ring-slate-100 sm:p-8">
                @csrf

                @foreach ([['nombre', 'Nombre', 'text', 'name'], ['correo', 'Correo electrónico', 'email', 'email'], ['asunto', 'Asunto', 'text', 'off']] as [$id, $etiqueta, $tipo, $auto])
                    <div>
                        <label for="{{ $id }}" class="block text-sm font-semibold text-primary-dark">{{ $etiqueta }}</label>
                        <input id="{{ $id }}" name="{{ $id }}" type="{{ $tipo }}" value="{{ old($id) }}" required autocomplete="{{ $auto }}"
                               @error($id) aria-invalid="true" aria-describedby="{{ $id }}-error" @enderror
                               class="{{ $campo }} @error($id) !border-red-600 @enderror">
                        @error($id)
                            <p id="{{ $id }}-error" class="mt-1 text-sm text-red-700">{{ $message }}</p>
                        @enderror
                    </div>
                @endforeach

                <div>
                    <label for="mensaje" class="block text-sm font-semibold text-primary-dark">Mensaje</label>
                    <textarea id="mensaje" name="mensaje" rows="5" required
                              @error('mensaje') aria-invalid="true" aria-describedby="mensaje-error" @enderror
                              class="{{ $campo }} @error('mensaje') !border-red-600 @enderror">{{ old('mensaje') }}</textarea>
                    @error('mensaje')
                        <p id="mensaje-error" class="mt-1 text-sm text-red-700">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="inline-flex items-center gap-2 rounded-full bg-accent px-6 py-3 font-heading text-sm font-semibold text-primary-dark transition hover:bg-accent-dark">
                    Enviar mensaje <x-icon name="arrow-right" class="h-4 w-4" />
                </button>
            </form>
        </div>

        {{-- Datos y mapa --}}
        <div class="space-y-6">
            <ul class="space-y-4 rounded-2xl bg-slate-50 p-6">
                <li class="flex gap-3"><x-icon name="map-pin" class="h-6 w-6 shrink-0 text-primary" />{{ $contacto['direccion'] }}</li>
                <li class="flex gap-3"><x-icon name="phone" class="h-6 w-6 shrink-0 text-primary" />{{ $contacto['telefono'] }}</li>
                <li class="flex gap-3"><x-icon name="envelope" class="h-6 w-6 shrink-0 text-primary" /><a href="mailto:{{ $contacto['correo'] }}" class="hover:text-primary">{{ $contacto['correo'] }}</a></li>
                <li class="flex gap-3"><x-icon name="clock" class="h-6 w-6 shrink-0 text-primary" />{{ $contacto['horario'] }}</li>
            </ul>

            <iframe src="{{ $contacto['mapa'] }}" title="Mapa de ubicación del Colegio San Luquitas"
                    class="h-80 w-full rounded-2xl border-0 shadow-md" loading="lazy" allowfullscreen
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </section>
@endsection
