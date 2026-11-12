@extends('admin.layout')

@section('title', 'Panel')

@section('content')
    <h1 class="font-heading text-3xl font-bold text-primary-dark">Hola, {{ auth()->user()->name }}</h1>
    <p class="mt-1 text-slate-500">Resumen del módulo de administración.</p>

    <div class="mt-8 grid gap-4 sm:grid-cols-3">
        @foreach ([['Usuarios registrados', $totalUsuarios, 'users', 'bg-primary/10 text-primary'], ['Administradores', $totalAdmins, 'shield-check', 'bg-accent/20 text-accent-dark'], ['Cuentas inactivas', $totalInactivos, 'clock', 'bg-slate-200 text-slate-600']] as [$etiqueta, $valor, $icono, $color])
            <div class="flex items-center gap-4 rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
                <span class="flex h-12 w-12 items-center justify-center rounded-xl {{ $color }}"><x-icon :name="$icono" class="h-6 w-6" /></span>
                <div>
                    <p class="font-heading text-2xl font-bold text-primary-dark">{{ $valor }}</p>
                    <p class="text-sm text-slate-500">{{ $etiqueta }}</p>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-8 rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <h2 class="font-heading text-lg font-semibold text-primary-dark">Accesos rápidos</h2>
        <div class="mt-4 flex flex-wrap gap-3">
            <a href="{{ route('admin.usuarios.create') }}" class="rounded-full bg-accent px-5 py-2.5 font-heading text-sm font-semibold text-primary-dark transition hover:bg-accent-dark">Registrar usuario</a>
            <a href="{{ route('admin.usuarios.index') }}" class="rounded-full border-2 border-primary px-5 py-2.5 font-heading text-sm font-semibold text-primary transition hover:bg-primary hover:text-white">Ver usuarios</a>
        </div>
    </div>
@endsection
