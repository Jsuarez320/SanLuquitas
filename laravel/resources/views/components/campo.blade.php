{{--
    Campo de formulario con etiqueta flotante (la etiqueta vive dentro del campo).

    Props:
      name    nombre del campo (también se usa para old() y los errores de validación)
      label   texto de la etiqueta
      tipo    'input' (por defecto), 'textarea' o 'select'
      type    tipo del <input> (text, email, password, date…)
      value   valor inicial (se reemplaza por old(name) si hubo error de validación)
      fija    true si la etiqueta debe quedar siempre arriba (select y date, que nunca están "vacíos")
      ayuda   texto de ayuda bajo el campo
      rows    filas del textarea
    Slots:
      (default)  las <option> cuando tipo = select
      trailing   contenido pegado dentro del campo (ej. botón de mostrar contraseña, contador)
    Cualquier otro atributo (id, required, autocomplete, maxlength, x-model, list…) pasa al campo.
    La clase (class) se aplica al contenedor.
--}}
@props(['name', 'label', 'tipo' => 'input', 'type' => 'text', 'value' => null, 'fija' => false, 'ayuda' => null, 'rows' => 4])

@php
    $id = $attributes->get('id', $name);
    $error = $errors->first($name);
    $describe = trim(($ayuda ? "$id-ayuda " : '').($error ? "$id-error" : ''));
    $actual = $type === 'password' ? null : old($name, $value);

    $campo = 'peer block w-full rounded-xl border bg-white px-4 pb-2 pt-6 text-slate-800 shadow-sm transition focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary '
        .($error ? 'border-red-600' : 'border-slate-300')
        .($tipo === 'select' ? ' appearance-none pr-10' : '')
        .(isset($trailing) && $tipo === 'input' ? ' pr-12' : '');

    // Vacío y sin foco → la etiqueta está dentro del campo; con foco o contenido → sube y se achica.
    $etiqueta = 'pointer-events-none absolute left-4 top-2 origin-left text-xs font-medium text-slate-500 transition-all duration-200 peer-focus:text-primary peer-aria-invalid:text-red-700'
        .($fija ? '' : ' peer-[&:placeholder-shown:not(:focus)]:top-4 peer-[&:placeholder-shown:not(:focus)]:text-base');

    $atributos = $attributes->except(['class', 'id'])->merge([
        'id' => $id,
        'name' => $name,
        'class' => $campo,
        'aria-invalid' => $error ? 'true' : null,
        'aria-describedby' => $describe ?: null,
    ]);
@endphp

<div {{ $attributes->only('class') }}>
    <div class="relative">
        @if ($tipo === 'textarea')
            <textarea rows="{{ $rows }}" placeholder=" " {{ $atributos }}>{{ $actual }}</textarea>
        @elseif ($tipo === 'select')
            <select {{ $atributos }}>{{ $slot }}</select>
            <x-icon name="chevron-down" class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-500" />
        @else
            <input type="{{ $type }}" placeholder=" " @if ($actual !== null) value="{{ $actual }}" @endif {{ $atributos }}>
        @endif

        <label for="{{ $id }}" class="{{ $etiqueta }}">{{ $label }}</label>

        @isset($trailing)
            {{ $trailing }}
        @endisset
    </div>

    @if ($ayuda)
        <p id="{{ $id }}-ayuda" class="mt-1 text-xs text-slate-500">{{ $ayuda }}</p>
    @endif
    @if ($error)
        <p id="{{ $id }}-error" class="mt-1 text-sm text-red-700" role="alert">{{ $error }}</p>
    @endif
</div>
