{{--
    Botón/enlace reutilizable.
    Props: href, variant (primary | accent | outline | outline-light), external (abre en pestaña nueva).
--}}
@props(['href' => '#', 'variant' => 'primary', 'external' => false])

@php
    $variantes = [
        'primary' => 'bg-primary text-white hover:bg-primary-dark',
        'accent' => 'bg-accent text-primary-dark hover:bg-accent-dark',
        'outline' => 'border-2 border-primary text-primary hover:bg-primary hover:text-white',
        'outline-light' => 'border-2 border-white text-white hover:bg-white hover:text-primary-dark',
    ];
    $clases = 'inline-flex items-center justify-center gap-2 rounded-full px-6 py-3 font-heading text-sm font-semibold transition '
        .($variantes[$variant] ?? $variantes['primary']);
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => $clases]) }}
   @if ($external) target="_blank" rel="noopener noreferrer" @endif>
    {{ $slot }}
</a>
