{{-- Encabezado de sección. Props: eyebrow (texto pequeño), title, subtitle, align (center|left), light (fondo oscuro). --}}
@props(['eyebrow' => null, 'title', 'subtitle' => null, 'align' => 'center', 'light' => false])

<div {{ $attributes->merge(['class' => 'mb-10 max-w-2xl '.($align === 'center' ? 'mx-auto text-center' : '')]) }}>
    @if ($eyebrow)
        <p class="mb-2 font-heading text-sm font-semibold uppercase tracking-widest {{ $light ? 'text-accent' : 'text-primary' }}">{{ $eyebrow }}</p>
    @endif
    <h2 class="font-heading text-3xl font-bold sm:text-4xl {{ $light ? 'text-white' : 'text-primary-dark' }}">{{ $title }}</h2>
    @if ($subtitle)
        <p class="mt-3 text-lg {{ $light ? 'text-blue-100' : 'text-slate-600' }}">{{ $subtitle }}</p>
    @endif
</div>
