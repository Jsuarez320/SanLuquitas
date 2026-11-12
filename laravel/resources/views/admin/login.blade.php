@extends('admin.layout')

@section('title', 'Iniciar sesión')


@section('content')
    <div class="mx-auto mt-12 w-full max-w-sm motion-safe:animate-fade-up">
        <div class="mb-8 text-center">
            <x-isotipo class="mx-auto mb-3 h-24 w-24" />
            <h1 class="font-heading text-2xl font-bold text-primary-dark">Administración</h1>
            <p class="mt-1 text-sm text-slate-500">Inicie sesión para continuar</p>
        </div>

        <form method="POST" action="{{ route('admin.login.enviar') }}" novalidate
              class="space-y-5 rounded-2xl bg-white p-6 shadow-md shadow-slate-200/60 ring-1 ring-slate-100">
            @csrf

            <x-campo name="username" label="Usuario" required autofocus autocomplete="username" />

            <div x-data="{ ver: false }">
                <x-campo name="password" label="Contraseña" type="password" required autocomplete="current-password" x-bind:type="ver ? 'text' : 'password'">
                    <x-slot:trailing>
                        <button type="button" @click="ver = !ver" class="absolute right-3 top-1/2 -translate-y-1/2 rounded-full p-1 text-slate-500 transition hover:text-primary"
                                :aria-label="ver ? 'Ocultar contraseña' : 'Mostrar contraseña'">
                            <x-icon name="eye" class="h-5 w-5" />
                        </button>
                    </x-slot:trailing>
                </x-campo>
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
