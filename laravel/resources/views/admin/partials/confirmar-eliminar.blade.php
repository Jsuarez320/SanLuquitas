{{--
    Diálogo de confirmación para eliminar (único para todo el panel).
    Se abre con: $dispatch('confirmar-eliminar', { titulo: '...', url: '...' })
    Foco inicial en "Conservar" (la opción segura), Esc o clic fuera para cerrar.
--}}
<div x-data="{ abierto: false, titulo: '', url: '' }"
     @confirmar-eliminar.window="titulo = $event.detail.titulo; url = $event.detail.url; abierto = true; $nextTick(() => $refs.conservar.focus())"
     @keydown.escape.window="abierto = false"
     x-show="abierto" x-cloak
     class="fixed inset-0 z-[80] flex items-center justify-center p-4"
     role="dialog" aria-modal="true" aria-labelledby="eliminar-titulo" aria-describedby="eliminar-texto">

    <div x-show="abierto" x-transition.opacity.duration.250ms @click="abierto = false" class="absolute inset-0 bg-primary-dark/60 backdrop-blur-sm"></div>

    <div x-show="abierto" x-transition:enter="transition duration-300 ease-out" x-transition:enter-start="opacity-0 scale-95 translate-y-3"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition duration-150 ease-in"
         x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
         class="relative w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl">
        <span class="flex h-12 w-12 items-center justify-center rounded-full bg-red-100 text-red-700">
            <x-icon name="trash" class="h-6 w-6" />
        </span>
        <h2 id="eliminar-titulo" class="mt-4 font-heading text-xl font-bold text-primary-dark">¿Eliminar «<span x-text="titulo"></span>»?</h2>
        <p id="eliminar-texto" class="mt-2 text-slate-600">Dejará de verse en el sitio y no podrás recuperarla. Si solo quieres ocultarla, pásala a borrador.</p>

        <form method="POST" :action="url" class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
            @csrf
            @method('DELETE')
            <button type="button" x-ref="conservar" @click="abierto = false"
                    class="rounded-full border-2 border-slate-300 px-5 py-2.5 font-heading text-sm font-semibold text-slate-700 transition hover:bg-slate-100 active:scale-95">Conservarla</button>
            <button type="submit"
                    class="rounded-full bg-red-600 px-5 py-2.5 font-heading text-sm font-semibold text-white transition hover:bg-red-700 active:scale-95">Eliminar publicación</button>
        </form>
    </div>
</div>
