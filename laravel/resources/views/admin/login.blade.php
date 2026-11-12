@extends('admin.layout')

@section('title', 'Iniciar sesión')

@php
    $campo = 'mt-1 block w-full rounded-xl border border-slate-300 px-4 py-3 text-slate-800 shadow-sm focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary';
@endphp

@section('content')
    <div class="mx-auto mt-12 w-full max-w-sm">
        <div class="mb-8 text-center">
            <span class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-primary font-heading text-2xl font-bold text-white">SL</span>
            <h1 class="font-heading text-2xl font-bold text-primary-dark">Administración</h1>
            <p class="mt-1 text-sm text-slate-500">Inicie sesión para continuar</p>
        </div>

        <form method="POST" action="{{ route('admin.login.enviar') }}" novalidate
              class="space-y-5 rounded-2xl bg-white p-6 shadow-md shadow-slate-200/60 ring-1 ring-slate-100">
            @csrf

            <div>
                <label for="username" class="block text-sm font-semibold text-primary-dark">Usuario</label>
                <input id="username" name="username" type="text" value="{{ old('username') }}" required autofocus autocomplete="username"
                       placeholder="Ingrese su usuario"
                       @error('username') aria-invalid="true" aria-describedby="username-error" @enderror
                       class="{{ $campo }} @error('username') !border-red-600 @enderror">
                @error('username')
                    <p id="username-error" class="mt-1 text-sm text-red-700" role="alert">{{ $message }}</p>
                @enderror
            </div>

            <div x-data="{ ver: false }">
                <label for="password" class="block text-sm font-semibold text-primary-dark">Contraseña</label>
                <div class="relative">
                    <input id="password" name="password" :type="ver ? 'text' : 'password'" required autocomplete="current-password"
                           placeholder="Ingrese su contraseña"
                           @error('password') aria-invalid="true" aria-describedby="password-error" @enderror
                           class="{{ $campo }} pr-12 @error('password') !border-red-600 @enderror">
                    <button type="button" @click="ver = !ver" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 hover:text-primary"
                            :aria-label="ver ? 'Ocultar contraseña' : 'Mostrar contraseña'">
                        <x-icon name="eye" class="h-5 w-5" />
                    </button>
                </div>
                @error('password')
                    <p id="password-error" class="mt-1 text-sm text-red-700" role="alert">{{ $message }}</p>
                @enderror
            </div>

            <label class="flex items-center gap-2 text-sm text-slate-600">
                <input type="checkbox" name="recordar" value="1" class="h-4 w-4 rounded accent-primary"> Mantener la sesión iniciada
            </label>

            <button type="submit" class="w-full rounded-full bg-accent px-6 py-3 font-heading text-sm font-semibold text-primary-dark transition hover:bg-accent-dark">
                Iniciar sesión
            </button>
        </form>
    </div>
@endsection
