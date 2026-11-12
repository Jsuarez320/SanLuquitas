{{-- Tarjeta genérica con ícono y título opcionales. --}}
@props(['title' => null, 'icon' => null])

<div {{ $attributes->merge(['class' => 'rounded-2xl bg-white p-6 shadow-md shadow-slate-200/60 ring-1 ring-slate-100 transition hover:-translate-y-1 hover:shadow-lg']) }}>
    @if ($icon)
        <span class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-xl bg-primary/10 text-primary">
            <x-icon :name="$icon" class="h-6 w-6" />
        </span>
    @endif

    @if ($title)
        <h3 class="font-heading text-lg font-semibold text-primary-dark">{{ $title }}</h3>
    @endif

    <div class="{{ $title ? 'mt-2' : '' }} leading-relaxed text-slate-600">
        {{ $slot }}
    </div>
</div>
