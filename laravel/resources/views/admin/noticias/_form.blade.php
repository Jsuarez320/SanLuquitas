{{--
    Formulario compartido de crear/editar. Recibe: $noticia (modelo, nuevo o existente), $accion (URL),
    $metodo ('POST' | 'PUT'), $boton (texto del botón principal).
--}}
@php
    $campo = 'mt-1 block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-800 shadow-sm transition focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary';
    $error = fn ($c) => $errors->has($c) ? '!border-red-600' : '';
    $tipoActual = old('tipo', $noticia->tipo);
    $estadoActual = old('estado', $noticia->estado);
@endphp

<form method="POST" action="{{ $accion }}" enctype="multipart/form-data" novalidate
      x-data="{
          extracto: @js(old('extracto', $noticia->extracto ?? '')),
          preview: @js($noticia->imagen_path ? $noticia->imagen : null),
          quitar: false,
          elegir(e) {
              const f = e.target.files[0];
              if (!f) return;
              this.quitar = false;
              this.preview = URL.createObjectURL(f);
          },
      }"
      class="mt-6 grid gap-6 lg:grid-cols-[1fr_20rem]">
    @csrf
    @if ($metodo !== 'POST') @method($metodo) @endif

    {{-- Columna principal --}}
    <div class="space-y-5 rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200 motion-safe:animate-fade-up sm:p-8" style="animation-delay: 60ms">
        <div>
            <label for="titulo" class="block text-sm font-semibold text-primary-dark">Título</label>
            <input id="titulo" name="titulo" type="text" maxlength="150" required value="{{ old('titulo', $noticia->titulo) }}"
                   placeholder="Ej: Inscripciones abiertas para 2027"
                   @error('titulo') aria-invalid="true" aria-describedby="titulo-error" @enderror
                   class="{{ $campo }} {{ $error('titulo') }}">
            @error('titulo') <p id="titulo-error" class="mt-1 text-sm text-red-700">{{ $message }}</p> @enderror
        </div>

        <div>
            <div class="flex items-end justify-between">
                <label for="extracto" class="block text-sm font-semibold text-primary-dark">Resumen</label>
                <span class="text-xs tabular-nums" :class="extracto.length > 200 ? 'font-semibold text-red-700' : 'text-slate-400'" aria-hidden="true">
                    <span x-text="extracto.length"></span>/220
                </span>
            </div>
            <textarea id="extracto" name="extracto" rows="2" maxlength="220" required x-model="extracto"
                      placeholder="Una o dos frases que aparecerán en las tarjetas del sitio"
                      @error('extracto') aria-invalid="true" aria-describedby="extracto-error" @enderror
                      class="{{ $campo }} {{ $error('extracto') }}">{{ old('extracto', $noticia->extracto) }}</textarea>
            @error('extracto') <p id="extracto-error" class="mt-1 text-sm text-red-700">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="cuerpo" class="block text-sm font-semibold text-primary-dark">Contenido</label>
            <p id="cuerpo-ayuda" class="text-xs text-slate-500">Separa los párrafos con una línea en blanco.</p>
            <textarea id="cuerpo" name="cuerpo" rows="12" required aria-describedby="cuerpo-ayuda @error('cuerpo') cuerpo-error @enderror"
                      @error('cuerpo') aria-invalid="true" @enderror
                      class="{{ $campo }} {{ $error('cuerpo') }}">{{ old('cuerpo', $noticia->cuerpo) }}</textarea>
            @error('cuerpo') <p id="cuerpo-error" class="mt-1 text-sm text-red-700">{{ $message }}</p> @enderror
        </div>
    </div>

    {{-- Columna lateral --}}
    <aside class="space-y-5 motion-safe:animate-fade-up" style="animation-delay: 140ms">
        <div class="space-y-5 rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
            {{-- Tipo --}}
            <fieldset>
                <legend class="text-sm font-semibold text-primary-dark">Tipo</legend>
                <div class="mt-2 grid grid-cols-2 gap-2">
                    @foreach (\App\Models\Noticia::TIPOS as $valor => $etiqueta)
                        <label class="cursor-pointer">
                            <input type="radio" name="tipo" value="{{ $valor }}" class="peer sr-only" @checked($tipoActual === $valor)>
                            <span class="flex items-center justify-center gap-2 rounded-xl border-2 border-slate-200 px-3 py-2.5 text-sm font-semibold text-slate-600 transition duration-200 hover:border-primary/50 peer-checked:border-primary peer-checked:bg-primary peer-checked:text-white peer-focus-visible:outline peer-focus-visible:outline-[3px] peer-focus-visible:outline-offset-2 peer-focus-visible:outline-primary">
                                <x-icon :name="$valor === 'comunicado' ? 'megaphone' : 'newspaper'" class="h-4 w-4" /> {{ $etiqueta }}
                            </span>
                        </label>
                    @endforeach
                </div>
                @error('tipo') <p class="mt-1 text-sm text-red-700">{{ $message }}</p> @enderror
            </fieldset>

            {{-- Estado --}}
            <fieldset>
                <legend class="text-sm font-semibold text-primary-dark">Estado</legend>
                <div class="mt-2 grid grid-cols-2 gap-2">
                    @foreach (\App\Models\Noticia::ESTADOS as $valor => $etiqueta)
                        <label class="cursor-pointer">
                            <input type="radio" name="estado" value="{{ $valor }}" class="peer sr-only" @checked($estadoActual === $valor)>
                            <span class="flex items-center justify-center rounded-xl border-2 border-slate-200 px-3 py-2.5 text-sm font-semibold text-slate-600 transition duration-200 hover:border-primary/50 {{ $valor === 'publicado' ? 'peer-checked:border-green-600 peer-checked:bg-green-600' : 'peer-checked:border-slate-600 peer-checked:bg-slate-600' }} peer-checked:text-white peer-focus-visible:outline peer-focus-visible:outline-[3px] peer-focus-visible:outline-offset-2 peer-focus-visible:outline-primary">
                                {{ $etiqueta }}
                            </span>
                        </label>
                    @endforeach
                </div>
                <p class="mt-1.5 text-xs text-slate-500">Un borrador no se ve en el sitio.</p>
            </fieldset>

            <div>
                <label for="categoria" class="block text-sm font-semibold text-primary-dark">Categoría</label>
                <input id="categoria" name="categoria" type="text" maxlength="60" required list="categorias" value="{{ old('categoria', $noticia->categoria) }}"
                       placeholder="Ej: Académico"
                       @error('categoria') aria-invalid="true" aria-describedby="categoria-error" @enderror
                       class="{{ $campo }} {{ $error('categoria') }}">
                <datalist id="categorias">
                    @foreach (['Académico', 'Admisiones', 'Campus Virtual', 'Comunidad', 'Formación', 'Institucional'] as $c)
                        <option value="{{ $c }}">
                    @endforeach
                </datalist>
                @error('categoria') <p id="categoria-error" class="mt-1 text-sm text-red-700">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="publicada_en" class="block text-sm font-semibold text-primary-dark">Fecha de publicación</label>
                <input id="publicada_en" name="publicada_en" type="date" required value="{{ old('publicada_en', $noticia->publicada_en?->toDateString()) }}"
                       @error('publicada_en') aria-invalid="true" aria-describedby="fecha-error" @enderror
                       class="{{ $campo }} {{ $error('publicada_en') }}">
                <p class="mt-1 text-xs text-slate-500">Si es una fecha futura, se mostrará ese día.</p>
                @error('publicada_en') <p id="fecha-error" class="mt-1 text-sm text-red-700">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Imagen --}}
        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <p class="text-sm font-semibold text-primary-dark">Imagen <span class="font-normal text-slate-400">(opcional)</span></p>

            <div class="mt-2 overflow-hidden rounded-xl bg-slate-100">
                <template x-if="preview && !quitar">
                    <img :src="preview" alt="Vista previa de la imagen" class="aspect-[16/10] w-full object-cover motion-safe:animate-pop-in">
                </template>
                <div x-show="!preview || quitar" class="flex aspect-[16/10] flex-col items-center justify-center gap-1 text-slate-400">
                    <x-icon name="photo" class="h-8 w-8" />
                    <span class="text-xs">Sin imagen: se usará una genérica</span>
                </div>
            </div>

            <label class="mt-3 flex cursor-pointer items-center justify-center gap-2 rounded-full border-2 border-primary px-4 py-2 font-heading text-sm font-semibold text-primary transition hover:bg-primary hover:text-white focus-within:outline focus-within:outline-[3px] focus-within:outline-offset-2 focus-within:outline-primary">
                <x-icon name="photo" class="h-4 w-4" /> Elegir imagen
                <input type="file" name="imagen" accept="image/jpeg,image/png,image/webp" class="sr-only" @change="elegir($event)"
                       @error('imagen') aria-invalid="true" aria-describedby="imagen-error" @enderror>
            </label>
            <p class="mt-1.5 text-xs text-slate-500">JPG, PNG o WebP, máximo 2 MB.</p>
            @error('imagen') <p id="imagen-error" class="mt-1 text-sm text-red-700">{{ $message }}</p> @enderror

            @if ($noticia->imagen_path)
                <label class="mt-3 flex items-center gap-2 text-sm text-slate-600">
                    <input type="checkbox" name="quitar_imagen" value="1" x-model="quitar" class="h-4 w-4 rounded accent-primary"> Quitar la imagen actual
                </label>
            @endif
        </div>

        <div class="flex flex-col gap-3">
            <button type="submit" class="rounded-full bg-accent px-6 py-3 font-heading text-sm font-semibold text-primary-dark shadow-sm transition hover:-translate-y-0.5 hover:bg-accent-dark hover:shadow-md active:scale-95">{{ $boton }}</button>
            <a href="{{ route('admin.noticias.index') }}" class="rounded-full px-6 py-3 text-center font-heading text-sm font-semibold text-slate-600 transition hover:bg-slate-200">Cancelar</a>
        </div>
    </aside>
</form>
