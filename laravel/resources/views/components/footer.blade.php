{{-- Pie de página: contacto, enlaces rápidos, redes y derechos. Datos desde config/sanluquitas.php. --}}
@php
    $contacto = config('sanluquitas.contacto');
    $redes = config('sanluquitas.redes');
@endphp

<footer class="on-dark bg-primary-dark text-blue-100">
    <div class="mx-auto grid max-w-7xl gap-10 px-4 py-14 sm:px-6 md:grid-cols-2 lg:grid-cols-4 lg:px-8">
        {{-- Marca --}}
        <div>
            <a href="{{ route('inicio') }}" class="flex items-center gap-2">
                <x-isotipo :tile="true" class="h-10 w-10" />
                <span class="font-heading text-lg font-bold text-white">San Luquitas</span>
            </a>
            <p class="mt-4 text-sm leading-relaxed">Educamos para transformar. Formación integral con excelencia, valores y tecnología.</p>
            <ul class="mt-5 flex gap-3">
                @foreach ($redes as $red)
                    <li>
                        <a href="{{ $red['url'] }}" target="_blank" rel="noopener noreferrer" aria-label="{{ $red['nombre'] }}"
                           class="flex h-10 w-10 items-center justify-center rounded-full bg-white/10 text-white transition hover:bg-accent hover:text-primary-dark">
                            <x-icon :name="$red['icono']" class="h-5 w-5" />
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- Enlaces rápidos --}}
        <div>
            <h2 class="font-heading text-base font-semibold text-white">Enlaces rápidos</h2>
            <ul class="mt-4 space-y-2 text-sm">
                <li><a href="{{ route('inicio') }}" class="hover:text-accent">Inicio</a></li>
                <li><a href="{{ route('nosotros') }}" class="hover:text-accent">Nosotros</a></li>
                <li><a href="{{ route('oferta') }}" class="hover:text-accent">Oferta académica</a></li>
                <li><a href="{{ route('noticias.index') }}" class="hover:text-accent">Noticias</a></li>
                <li><a href="{{ route('contacto') }}" class="hover:text-accent">Contacto</a></li>
                <li><a href="{{ config('sanluquitas.moodle_url') }}" target="_blank" rel="noopener noreferrer" class="hover:text-accent">Campus Virtual</a></li>
            </ul>
        </div>

        {{-- Contacto --}}
        <div class="lg:col-span-2">
            <h2 class="font-heading text-base font-semibold text-white">Contáctanos</h2>
            <ul class="mt-4 space-y-3 text-sm">
                <li class="flex gap-3"><x-icon name="map-pin" class="h-5 w-5 shrink-0 text-accent" />{{ $contacto['direccion'] }}</li>
                <li class="flex gap-3"><x-icon name="phone" class="h-5 w-5 shrink-0 text-accent" /><a href="tel:{{ preg_replace('/[^\d+]/', '', $contacto['telefono']) }}" class="hover:text-accent">{{ $contacto['telefono'] }}</a></li>
                <li class="flex gap-3"><x-icon name="envelope" class="h-5 w-5 shrink-0 text-accent" /><a href="mailto:{{ $contacto['correo'] }}" class="hover:text-accent">{{ $contacto['correo'] }}</a></li>
                <li class="flex gap-3"><x-icon name="clock" class="h-5 w-5 shrink-0 text-accent" />{{ $contacto['horario'] }}</li>
            </ul>
        </div>
    </div>

    <div class="border-t border-white/10 py-5 text-center text-sm">
        © 2026 Colegio San Luquitas
    </div>
</footer>
