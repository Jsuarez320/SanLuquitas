@extends('admin.layout')

@section('title', 'Usuarios')

@section('content')
    <div class="flex items-center justify-between">
        <h1 class="font-heading text-3xl font-bold text-primary-dark">Usuarios</h1>
        <a href="{{ route('admin.usuarios.create') }}" class="rounded-full bg-accent px-5 py-2.5 font-heading text-sm font-semibold text-primary-dark hover:bg-accent-dark">Registrar usuario</a>
    </div>

    <div class="mt-6 overflow-x-auto rounded-2xl bg-white shadow-sm ring-1 ring-slate-100">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                <tr>
                    <th scope="col" class="px-4 py-3">Nombre</th>
                    <th scope="col" class="px-4 py-3">Usuario</th>
                    <th scope="col" class="px-4 py-3">Correo</th>
                    <th scope="col" class="px-4 py-3">Rol</th>
                    <th scope="col" class="px-4 py-3">Estado</th>
                    <th scope="col" class="px-4 py-3">Último acceso</th>
                    <th scope="col" class="px-4 py-3"><span class="sr-only">Acciones</span></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($usuarios as $u)
                    <tr>
                        <td class="px-4 py-3 font-medium text-primary-dark">{{ $u->nombreCompleto() }}</td>
                        <td class="px-4 py-3">{{ $u->username ?? '—' }}</td>
                        <td class="px-4 py-3">{{ $u->email }}</td>
                        <td class="px-4 py-3">{{ $u->es_admin ? 'Administrador' : 'Empleado' }}</td>
                        <td class="px-4 py-3">
                            <span class="rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $u->activo ? 'bg-green-100 text-green-800' : 'bg-slate-200 text-slate-700' }}">{{ $u->activo ? 'Activo' : 'Inactivo' }}</span>
                        </td>
                        <td class="px-4 py-3">{{ $u->ultimo_login?->format('d/m/Y H:i') ?? 'Nunca' }}</td>
                        <td class="px-4 py-3 text-right">
                            @unless ($u->is(auth()->user()))
                                <form method="POST" action="{{ route('admin.usuarios.activo', $u) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-sm font-semibold text-primary hover:underline">{{ $u->activo ? 'Desactivar' : 'Activar' }}</button>
                                </form>
                            @endunless
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $usuarios->links() }}</div>
@endsection
