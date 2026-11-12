<?php

/*
|--------------------------------------------------------------------------
| Configuración del Portal Institucional San Luquitas
|--------------------------------------------------------------------------
| Datos institucionales centralizados para que las vistas no contengan
| valores "quemados" y sean fáciles de cambiar.
*/

return [

    // URL del campus virtual (Moodle). Se usa en todos los botones "Campus Virtual".
    'moodle_url' => env('MOODLE_URL', 'http://localhost:8080'),

    // Datos de contacto (placeholders: reemplazar por los reales).
    'contacto' => [
        'direccion' => 'Calle 123 # 45-67, Bogotá, Colombia',
        'telefono' => '+57 (601) 555 0123',
        'correo' => 'contacto@sanluquitas.edu.co',
        'horario' => 'Lunes a viernes, 7:00 a. m. – 4:00 p. m.',
        // URL del iframe de Google Maps (placeholder). Reemplazar por el embed real del colegio.
        'mapa' => 'https://www.google.com/maps?q=Bogot%C3%A1,+Colombia&output=embed',
    ],

    // Redes sociales (placeholders).
    'redes' => [
        ['nombre' => 'Facebook', 'icono' => 'facebook', 'url' => 'https://facebook.com/'],
        ['nombre' => 'Instagram', 'icono' => 'instagram', 'url' => 'https://instagram.com/'],
        ['nombre' => 'YouTube', 'icono' => 'youtube', 'url' => 'https://youtube.com/'],
    ],

    // Cifras de la franja estadística de la página de inicio.
    'cifras' => [
        ['valor' => '1.200+', 'etiqueta' => 'Estudiantes', 'icono' => 'users'],
        ['valor' => '85', 'etiqueta' => 'Docentes', 'icono' => 'academic-cap'],
        ['valor' => '40', 'etiqueta' => 'Años de trayectoria', 'icono' => 'calendar'],
    ],
];
