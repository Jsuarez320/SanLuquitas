<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;

/**
 * Páginas institucionales del portal.
 * Los datos de ejemplo viven aquí para mantener las vistas sin lógica.
 */
class PageController extends Controller
{
    /** Inicio: hero, cifras, pilares, últimas noticias y banner de Moodle. */
    public function inicio()
    {
        $pilares = [
            ['icono' => 'academic-cap', 'titulo' => 'Excelencia académica', 'texto' => 'Un currículo exigente y actualizado, con docentes comprometidos con el aprendizaje de cada estudiante.'],
            ['icono' => 'heart', 'titulo' => 'Formación en valores', 'texto' => 'Educamos personas íntegras: respeto, solidaridad y responsabilidad guían nuestra convivencia diaria.'],
            ['icono' => 'computer-desktop', 'titulo' => 'Tecnología', 'texto' => 'Campus virtual y herramientas digitales que amplían el aula y preparan para el futuro.'],
        ];

        return view('inicio', [
            'pilares' => $pilares,
            'noticias' => array_slice(NewsController::articulos(), 0, 3),
        ]);
    }

    /** Nosotros: historia, misión, visión, valores y equipo directivo. */
    public function nosotros()
    {
        return view('nosotros', [
            'valores' => [
                ['icono' => 'shield-check', 'titulo' => 'Integridad', 'texto' => 'Actuamos con honestidad y coherencia.'],
                ['icono' => 'heart', 'titulo' => 'Respeto', 'texto' => 'Valoramos la dignidad de cada persona.'],
                ['icono' => 'users', 'titulo' => 'Solidaridad', 'texto' => 'Trabajamos juntos por el bien común.'],
                ['icono' => 'star', 'titulo' => 'Excelencia', 'texto' => 'Buscamos la mejora continua en todo lo que hacemos.'],
            ],
            // Nombres ficticios de ejemplo.
            'directivos' => [
                ['nombre' => 'María Fernanda Ortiz', 'cargo' => 'Rectora'],
                ['nombre' => 'Carlos Andrés Medina', 'cargo' => 'Coordinador académico'],
                ['nombre' => 'Laura Patricia Gómez', 'cargo' => 'Coordinadora de convivencia'],
                ['nombre' => 'Jorge Iván Ramírez', 'cargo' => 'Director de tecnología'],
            ],
        ]);
    }

    /** Oferta académica: niveles (tabs) y cursos virtuales en Moodle. */
    public function oferta()
    {
        return view('oferta', [
            'niveles' => [
                [
                    'id' => 'preescolar', 'nombre' => 'Preescolar', 'grados' => 'Prejardín, Jardín y Transición',
                    'descripcion' => 'Un primer encuentro con el aprendizaje a través del juego, la exploración y el desarrollo de la autonomía.',
                    'puntos' => ['Desarrollo socioemocional', 'Iniciación a la lectoescritura', 'Arte, música y psicomotricidad'],
                ],
                [
                    'id' => 'primaria', 'nombre' => 'Primaria', 'grados' => 'De 1.º a 5.º',
                    'descripcion' => 'Construimos las bases del conocimiento con metodologías activas, proyectos y acompañamiento cercano.',
                    'puntos' => ['Matemáticas, lenguaje y ciencias', 'Bilingüismo e inglés intensivo', 'Pensamiento computacional'],
                ],
                [
                    'id' => 'bachillerato', 'nombre' => 'Bachillerato', 'grados' => 'De 6.º a 11.º',
                    'descripcion' => 'Preparamos para la educación superior y la vida, con orientación vocacional y proyectos de investigación.',
                    'puntos' => ['Preparación para pruebas de Estado', 'Orientación vocacional', 'Proyectos de investigación y servicio social'],
                ],
            ],
            'cursos' => [
                ['icono' => 'computer-desktop', 'titulo' => 'Programación Primaria', 'nivel' => 'Primaria', 'texto' => 'Lógica y pensamiento computacional con retos lúdicos.'],
                ['icono' => 'book-open', 'titulo' => 'Comprensión lectora', 'nivel' => 'Primaria', 'texto' => 'Lecturas guiadas y actividades interactivas.'],
                ['icono' => 'academic-cap', 'titulo' => 'Preparación Pruebas Saber 11', 'nivel' => 'Bachillerato', 'texto' => 'Simulacros y refuerzo por áreas.'],
            ],
        ]);
    }

    /** Contacto: formulario + datos + mapa (los datos vienen de config/sanluquitas.php). */
    public function contacto()
    {
        return view('contacto');
    }

    /** Procesa el formulario de contacto (validado por ContactRequest). */
    public function enviarContacto(ContactRequest $request)
    {
        // TODO: enviar por correo (Mail::to(...)) o guardar en base de datos.
        $request->validated();

        return redirect()
            ->route('contacto')
            ->with('exito', '¡Gracias por escribirnos! Hemos recibido tu mensaje y te responderemos pronto.');
    }
}
