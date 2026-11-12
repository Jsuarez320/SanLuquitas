<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Colegio San Luquitas') | Educamos para transformar</title>
    <meta name="description" content="@yield('description', 'Portal institucional del Colegio San Luquitas: educación integral con excelencia académica, valores y tecnología.')">

    <x-favicon />

    {{-- Tipografías: Poppins (títulos) e Inter (texto) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white font-sans text-slate-700 antialiased">
    {{-- Enlace para saltar al contenido (accesibilidad por teclado) --}}
    <a href="#contenido" class="sr-only z-[60] rounded-lg bg-accent px-4 py-2 font-semibold text-primary-dark focus:not-sr-only focus:fixed focus:left-4 focus:top-4">
        Saltar al contenido
    </a>

    <x-navbar />

    {{-- pt-16 compensa la altura de la navbar fija --}}
    <main id="contenido" class="pt-16">
        @yield('content')
    </main>

    <x-footer />

    {{-- Modal de inicio de sesión (se abre desde el botón de la barra de navegación) --}}
    <x-login-modal />
</body>
</html>
