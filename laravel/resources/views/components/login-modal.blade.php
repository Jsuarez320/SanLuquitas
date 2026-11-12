{{--
    Modal de inicio de sesión (sitio público). Se abre con: $dispatch('abrir-login').
    Envía al mismo login del admin; si hay error de credenciales vuelve a esta página
    con el modal abierto. Esc o clic fuera lo cierran; el foco entra en "Usuario".
--}}
@guest

    <div x-data="{ abierto: @js($errors->hasAny(['username', 'password'])), ver: false }"
         x-init="if (abierto) $nextTick(() => $refs.usuario.focus())"
         x-effect="document.body.classList.toggle('overflow-hidden', abierto)"
         @abrir-login.window="abierto = true; $nextTick(() => $refs.usuario.focus())"
         @keydown.escape.window="abierto = false"
         x-show="abierto" x-cloak
         class="fixed inset-0 z-[90] flex items-center justify-center p-4"
         role="dialog" aria-modal="true" aria-labelledby="login-titulo">

        <div x-show="abierto" x-transition.opacity.duration.250ms @click="abierto = false"
             class="absolute inset-0 bg-primary-dark/70 backdrop-blur-sm"></div>

        <div x-show="abierto"
             x-transition:enter="transition duration-300 ease-out" x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition duration-150 ease-in" x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="relative w-full max-w-sm rounded-2xl bg-white p-6 shadow-2xl sm:p-8">

            <button type="button" @click="abierto = false" aria-label="Cerrar"
                    class="absolute right-3 top-3 rounded-full p-2 text-slate-400 transition hover:bg-slate-100 hover:text-slate-700">
                <x-icon name="x-mark" class="h-5 w-5" />
            </button>

            <div class="text-center">
                <x-isotipo class="mx-auto h-20 w-20" />
                <h2 id="login-titulo" class="mt-3 font-heading text-2xl font-bold text-primary-dark">Iniciar sesión</h2>
                <p class="mt-1 text-sm text-slate-500">Acceso al panel de administración</p>
            </div>

            <form method="POST" action="{{ route('admin.login.enviar') }}" novalidate class="mt-6 space-y-5">
                @csrf

                <x-campo name="username" id="modal-username" label="Usuario" x-ref="usuario" required autocomplete="username" />

                <x-campo name="password" id="modal-password" label="Contraseña" type="password" required autocomplete="current-password"
                         x-bind:type="ver ? 'text' : 'password'">
                    <x-slot:trailing>
                        <button type="button" @click="ver = !ver" class="absolute right-3 top-1/2 -translate-y-1/2 rounded-full p-1 text-slate-500 transition hover:text-primary"
                                :aria-label="ver ? 'Ocultar contraseña' : 'Mostrar contraseña'">
                            <x-icon name="eye" class="h-5 w-5" />
                        </button>
                    </x-slot:trailing>
                </x-campo>

                <button type="submit"
                        class="w-full rounded-full bg-accent px-6 py-3 font-heading text-sm font-semibold text-primary-dark transition hover:-translate-y-0.5 hover:bg-accent-dark hover:shadow-md active:scale-95">
                    Entrar
                </button>
            </form>
        </div>
    </div>
@endguest
