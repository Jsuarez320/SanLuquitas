{{--
    Barra de navegación fija. En móvil se convierte en menú hamburguesa (Alpine.js).
    El enlace de la sección actual se resalta según la ruta activa.
--}}
@php
    $enlaces = [
        ['texto' => 'Inicio', 'ruta' => 'inicio', 'activo' => request()->routeIs('inicio')],
        ['texto' => 'Nosotros', 'ruta' => 'nosotros', 'activo' => request()->routeIs('nosotros')],
        ['texto' => 'Oferta académica', 'ruta' => 'oferta', 'activo' => request()->routeIs('oferta')],
        ['texto' => 'Noticias', 'ruta' => 'noticias.index', 'activo' => request()->routeIs('noticias.*')],
        ['texto' => 'Contacto', 'ruta' => 'contacto', 'activo' => request()->routeIs('contacto')],
    ];
@endphp

<header x-data="{ abierto: false }" class="fixed inset-x-0 top-0 z-50 bg-white/95 shadow-sm backdrop-blur">
    <nav class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8" aria-label="Navegación principal">
        {{-- Logo --}}
        <a href="{{ route('inicio') }}" class="flex items-center gap-2" aria-label="San Luquitas, ir al inicio">
            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-primary font-heading text-lg font-bold text-white">SL</span>
            <span class="font-heading text-lg font-bold text-primary-dark">San Luquitas</span>
        </a>

        {{-- Enlaces (escritorio) --}}
        <ul class="hidden items-center gap-1 lg:flex">
            @foreach ($enlaces as $enlace)
                <li>
                    <a href="{{ route($enlace['ruta']) }}"
                       @if ($enlace['activo']) aria-current="page" @endif
                       class="rounded-full px-4 py-2 text-sm font-medium transition {{ $enlace['activo'] ? 'bg-primary/10 text-primary' : 'text-slate-700 hover:bg-slate-100 hover:text-primary' }}">
                        {{ $enlace['texto'] }}
                    </a>
                </li>
            @endforeach
            <li class="ml-2">
                <x-button :href="config('sanluquitas.moodle_url')" variant="accent" :external="true" class="!py-2">
                    Campus Virtual
                </x-button>
            </li>
        </ul>

        {{-- Botón hamburguesa (móvil) --}}
        <button type="button" class="rounded-lg p-2 text-primary-dark lg:hidden"
                @click="abierto = !abierto" :aria-expanded="abierto" aria-controls="menu-movil" aria-label="Abrir menú">
            <x-icon name="bars-3" x-show="!abierto" />
            <x-icon name="x-mark" x-show="abierto" x-cloak />
        </button>
    </nav>

    {{-- Menú móvil --}}
    <div id="menu-movil" x-show="abierto" x-cloak x-transition @keydown.escape.window="abierto = false"
         class="border-t border-slate-100 bg-white lg:hidden">
        <ul class="space-y-1 px-4 py-4">
            @foreach ($enlaces as $enlace)
                <li>
                    <a href="{{ route($enlace['ruta']) }}"
                       @if ($enlace['activo']) aria-current="page" @endif
                       class="block rounded-xl px-4 py-3 font-medium {{ $enlace['activo'] ? 'bg-primary/10 text-primary' : 'text-slate-700 hover:bg-slate-100' }}">
                        {{ $enlace['texto'] }}
                    </a>
                </li>
            @endforeach
            <li class="pt-2">
                <x-button :href="config('sanluquitas.moodle_url')" variant="accent" :external="true" class="w-full">
                    Campus Virtual
                </x-button>
            </li>
        </ul>
    </div>
</header>
