{{-- Tarjeta de noticia. Prop: noticia (array con slug, titulo, categoria, fecha, fecha_legible, extracto, imagen). --}}
@props(['noticia'])

<article class="group flex flex-col overflow-hidden rounded-2xl bg-white shadow-md shadow-slate-200/60 ring-1 ring-slate-100 transition hover:-translate-y-1 hover:shadow-lg">
    <a href="{{ route('noticias.show', $noticia['slug']) }}" class="block overflow-hidden">
        <img src="{{ $noticia['imagen'] }}" alt="Imagen de la noticia: {{ $noticia['titulo'] }}" loading="lazy"
             class="aspect-[16/10] w-full object-cover transition duration-300 group-hover:scale-105">
    </a>
    <div class="flex flex-1 flex-col p-6">
        <div class="mb-3 flex items-center gap-3 text-sm">
            <span class="rounded-full bg-accent/20 px-3 py-1 font-medium text-primary-dark">{{ $noticia['categoria'] }}</span>
            <time datetime="{{ $noticia['fecha'] }}" class="text-slate-600">{{ $noticia['fecha_legible'] }}</time>
        </div>
        <h3 class="font-heading text-lg font-semibold text-primary-dark">
            <a href="{{ route('noticias.show', $noticia['slug']) }}" class="hover:text-primary">{{ $noticia['titulo'] }}</a>
        </h3>
        <p class="mt-2 flex-1 text-slate-600">{{ $noticia['extracto'] }}</p>
        <a href="{{ route('noticias.show', $noticia['slug']) }}" class="mt-4 inline-flex items-center gap-1 font-semibold text-primary hover:text-primary-dark">
            Leer más <x-icon name="arrow-right" class="h-4 w-4" />
            <span class="sr-only">sobre {{ $noticia['titulo'] }}</span>
        </a>
    </div>
</article>
