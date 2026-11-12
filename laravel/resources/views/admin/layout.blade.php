<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'Administración') | San Luquitas</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 font-sans text-slate-700 antialiased">
@auth
    @php
        $menu = [
            ['Panel', 'admin.dashboard', 'admin.dashboard', 'computer-desktop'],
            ['Noticias', 'admin.noticias.index', 'admin.noticias.*', 'newspaper'],
            ['Usuarios', 'admin.usuarios.index', 'admin.usuarios.*', 'users'],
        ];
    @endphp

    <div x-data="{ abierto: false }" class="min-h-screen lg:flex">
        {{-- Barra lateral: fija a pantalla completa (en escritorio se queda al hacer scroll) --}}
        <aside class="on-dark fixed inset-y-0 left-0 z-40 w-64 -translate-x-full overflow-y-auto bg-primary-dark transition-transform lg:sticky lg:top-0 lg:h-screen lg:shrink-0 lg:translate-x-0"
               :class="{ 'translate-x-0': abierto }">
            <div class="flex h-16 items-center gap-2 px-5">
                <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-accent font-heading font-bold text-primary-dark">SL</span>
                <span class="font-heading text-lg font-bold text-white">Admin</span>
            </div>

            <nav class="space-y-1 px-3 py-4" aria-label="Administración">
                @foreach ($menu as [$texto, $ruta, $patron, $icono])
                    @php $activo = request()->routeIs($patron); @endphp
                    <a href="{{ route($ruta) }}" @if ($activo) aria-current="page" @endif
                       class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition duration-200 {{ $activo ? 'bg-white/15 text-white' : 'text-blue-100 hover:translate-x-1 hover:bg-white/10 hover:text-white' }}">
                        <x-icon :name="$icono" class="h-5 w-5 transition group-hover:scale-110 {{ $activo ? 'text-accent' : '' }}" /> {{ $texto }}
                    </a>
                @endforeach
                <a href="{{ route('inicio') }}" target="_blank" rel="noopener"
                   class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-blue-100 transition hover:bg-white/10 hover:text-white">
                    <x-icon name="arrow-right" class="h-5 w-5" /> Ver sitio público
                </a>
            </nav>
        </aside>

        {{-- Fondo oscuro en móvil --}}
        <div x-show="abierto" x-cloak @click="abierto = false" class="fixed inset-0 z-30 bg-black/40 lg:hidden"></div>

        <div class="min-w-0 flex-1">
            {{-- Barra superior --}}
            <header class="flex h-16 items-center justify-between bg-white px-4 shadow-sm sm:px-6">
                <button type="button" class="rounded-lg p-2 text-primary-dark lg:hidden" @click="abierto = true" aria-label="Abrir menú">
                    <x-icon name="bars-3" class="h-6 w-6" />
                </button>
                <p class="hidden font-heading font-semibold text-primary-dark lg:block">@yield('title', 'Administración')</p>

                <div class="flex items-center gap-4">
                    <div class="text-right leading-tight">
                        <p class="text-sm font-semibold text-primary-dark">{{ auth()->user()->nombreCompleto() }}</p>
                        <p class="text-xs text-slate-500">Administrador</p>
                    </div>
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="rounded-full border-2 border-primary px-4 py-1.5 font-heading text-sm font-semibold text-primary transition hover:bg-primary hover:text-white">Salir</button>
                    </form>
                </div>
            </header>

            <main class="p-4 motion-safe:animate-fade-in sm:p-6 lg:p-8">
                @yield('content')
            </main>
        </div>
    </div>
@else
    <main class="p-4">
        @yield('content')
    </main>
@endauth

@include('admin.partials.alertas')
@include('admin.partials.confirmar-eliminar')
</body>
</html>
