@extends('admin.layout')

@section('title', 'Registrar usuario')

@section('content')
    <a href="{{ route('admin.usuarios.index') }}" class="inline-flex items-center gap-1 text-sm font-semibold text-primary transition hover:gap-2 hover:underline">
        <x-icon name="arrow-left" class="h-4 w-4" /> Volver a usuarios
    </a>
    <h1 class="mt-2 font-heading text-3xl font-bold text-primary-dark">Registrar usuario</h1>

    <form method="POST" action="{{ route('admin.usuarios.store') }}" novalidate
          class="mt-6 max-w-xl space-y-5 rounded-2xl bg-white p-6 shadow-md shadow-slate-200/60 ring-1 ring-slate-100 motion-safe:animate-fade-up sm:p-8">
        @csrf

        <div class="grid gap-5 sm:grid-cols-2">
            <x-campo name="name" label="Nombre" required autocomplete="given-name" />
            <x-campo name="apellido" label="Apellido" required autocomplete="family-name" />
        </div>
        <x-campo name="email" label="Correo electrónico" type="email" required autocomplete="email" />
        <x-campo name="username" label="Usuario" required autocomplete="off"
                 ayuda="Letras, números, guion y guion bajo. Con él inicia sesión." />
        <div class="grid gap-5 sm:grid-cols-2">
            <x-campo name="password" label="Contraseña" type="password" required autocomplete="new-password" />
            <x-campo name="password_confirmation" label="Confirmar contraseña" type="password" required autocomplete="new-password" />
        </div>
        <p class="-mt-2 text-xs text-slate-500">La contraseña debe tener al menos 8 caracteres, con letras y números.</p>

        <label class="flex items-center gap-2 text-sm text-slate-700">
            <input type="checkbox" name="es_admin" value="1" @checked(old('es_admin')) class="h-4 w-4 rounded accent-primary">
            Es administrador
        </label>

        <button type="submit" class="rounded-full bg-accent px-6 py-3 font-heading text-sm font-semibold text-primary-dark transition hover:-translate-y-0.5 hover:bg-accent-dark hover:shadow-md active:scale-95">Registrar usuario</button>
    </form>
@endsection
