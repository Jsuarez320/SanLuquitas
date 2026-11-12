{{--
    Isotipo de San Luquitas (birrete con piezas de rompecabezas).
    Prop: tile (true sobre fondos oscuros: lo pone sobre una base blanca para que se lea).
    Es decorativo (alt vacío) porque siempre va junto al nombre de la marca.
--}}
@props(['tile' => false])

<img src="{{ asset('images/marca/isotipo.png') }}" alt="" width="256" height="256"
     {{ $attributes->merge(['class' => 'h-10 w-10 shrink-0 object-contain'.($tile ? ' rounded-lg bg-white p-1' : '')]) }}>
