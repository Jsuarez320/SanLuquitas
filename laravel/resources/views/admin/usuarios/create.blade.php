@extends('admin.layout')

@section('title', 'Registrar usuario')

@php
    $campo = 'mt-1 block w-full rounded-xl border border-slate-300 px-4 py-3 text-slate-800 shadow-sm focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary';
    $campos = [
        ['name', 'Nombre', 'text', 'given-name'],
        ['apellido', 'Apellido', 'text', 'family-name'],
        ['email', 'Correo electrónico', 'email', 'email'],
        ['username', 'Usuario', 'text', 'off'],
        ['password', 'Contraseña', 'password', 'new-password'],
        ['password_confirmation', 'Confirmar contraseña', 'password', 'new-password'],
    ];
@endphp

@section('content')
    <a href="{{ route('admin.usuarios.index') }}" class="inline-flex items-center gap-1 text-sm font-semibold text-primary hover:underline">
        <x-icon name="arrow-left" class="h-4 w-4" /> Volver a usuarios
    </a>
    <h1 class="mt-2 font-heading text-3xl font-bold text-primary-dark">Registrar usuario</h1>

    <form method="POST" action="{{ route('admin.usuarios.store') }}" novalidate
          class="mt-6 max-w-xl space-y-5 rounded-2xl bg-white p-6 shadow-md shadow-slate-200/60 ring-1 ring-slate-100 sm:p-8">
        @csrf

        @foreach ($campos as [$id, $etiqueta, $tipo, $auto])
            <div>
                <label for="{{ $id }}" class="block text-sm font-semibold text-primary-dark">{{ $etiqueta }}</label>
                <input id="{{ $id }}" name="{{ $id }}" type="{{ $tipo }}" required autocomplete="{{ $auto }}"
                       @if ($tipo !== 'password') value="{{ old($id) }}" @endif
                       @error($id) aria-invalid="true" aria-describedby="{{ $id }}-error" @enderror
                       class="{{ $campo }} @error($id) !border-red-600 @enderror">
                @error($id)
                    <p id="{{ $id }}-error" class="mt-1 text-sm text-red-700">{{ $message }}</p>
                @enderror
            </div>
        @endforeach

        <label class="flex items-center gap-2 text-sm text-slate-700">
            <input type="checkbox" name="es_admin" value="1" @checked(old('es_admin')) class="h-4 w-4 rounded accent-primary">
            Es administrador
        </label>

        <button type="submit" class="rounded-full bg-accent px-6 py-3 font-heading text-sm font-semibold text-primary-dark hover:bg-accent-dark">Registrar usuario</button>
    </form>
@endsection
