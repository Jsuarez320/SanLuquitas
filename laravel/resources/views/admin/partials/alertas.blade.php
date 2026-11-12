{{--
    Avisos tipo toast: aparecen arriba a la derecha, se cierran solos a los 6 s
    (o con el botón) y se anuncian a lector de pantalla (role status / alert).
--}}
@php
    $avisos = array_filter([
        ['exito', session('exito')],
        ['error', session('error')],
    ], fn ($a) => filled($a[1]));
@endphp

@if ($avisos)
    <div class="pointer-events-none fixed right-4 top-4 z-[70] flex w-[calc(100%-2rem)] max-w-sm flex-col gap-3">
        @foreach ($avisos as [$tipo, $mensaje])
            <div x-data="{ visible: true }" x-init="setTimeout(() => visible = false, 6000)"
                 x-show="visible" x-transition:leave="transition duration-300 ease-in" x-transition:leave-start="opacity-100 translate-x-0"
                 x-transition:leave-end="opacity-0 translate-x-6"
                 role="{{ $tipo === 'error' ? 'alert' : 'status' }}"
                 class="pointer-events-auto relative overflow-hidden rounded-2xl bg-white p-4 pr-10 shadow-xl shadow-slate-900/10 ring-1 motion-safe:animate-toast-in {{ $tipo === 'error' ? 'ring-red-200' : 'ring-green-200' }}">
                <div class="flex gap-3">
                    <span class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full {{ $tipo === 'error' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                        <x-icon :name="$tipo === 'error' ? 'x-mark' : 'check-circle'" class="h-4 w-4" />
                    </span>
                    <p class="text-sm font-medium text-slate-800">{{ $mensaje }}</p>
                </div>
                <button type="button" @click="visible = false" aria-label="Cerrar aviso"
                        class="absolute right-2 top-2 rounded-lg p-1 text-slate-400 transition hover:bg-slate-100 hover:text-slate-700">
                    <x-icon name="x-mark" class="h-4 w-4" />
                </button>
                {{-- Barra que se vacía mostrando cuánto falta para que se cierre --}}
                <span class="absolute inset-x-0 bottom-0 h-1 origin-left motion-safe:animate-toast-bar {{ $tipo === 'error' ? 'bg-red-400' : 'bg-green-400' }}"></span>
            </div>
        @endforeach
    </div>
@endif
