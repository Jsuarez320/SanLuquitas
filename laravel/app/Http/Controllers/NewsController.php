<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

/**
 * Noticias del colegio.
 * Por ahora usa datos de ejemplo (sin base de datos).
 */
class NewsController extends Controller
{
    /**
     * Noticias de ejemplo, de la más reciente a la más antigua.
     * También las usa PageController para mostrar las últimas 3 en el inicio.
     */
    public static function articulos(): array
    {
        $noticias = [
            [
                'slug' => 'feria-de-ciencias-2026',
                'titulo' => 'Gran Feria de Ciencias 2026',
                'categoria' => 'Académico',
                'fecha' => '2026-10-28',
                'extracto' => 'Más de 80 proyectos de nuestros estudiantes se presentaron ante la comunidad educativa.',
                'contenido' => [
                    'Con enorme entusiasmo se realizó la Feria de Ciencias 2026, donde estudiantes de todos los niveles presentaron proyectos de robótica, medio ambiente y salud.',
                    'Los trabajos fueron evaluados por un jurado de docentes y padres de familia invitados, quienes destacaron la creatividad y el rigor investigativo.',
                    'Agradecemos a las familias por su acompañamiento y felicitamos a todos los participantes.',
                ],
            ],
            [
                'slug' => 'nuevo-curso-programacion-primaria',
                'titulo' => 'Nuevo curso virtual: Programación Primaria',
                'categoria' => 'Campus Virtual',
                'fecha' => '2026-10-15',
                'extracto' => 'Ya está disponible en el Campus Virtual el curso que introduce el pensamiento computacional.',
                'contenido' => [
                    'Los estudiantes de primaria ya pueden acceder al curso "Programación Primaria" en nuestro Campus Virtual.',
                    'A través de retos y actividades lúdicas aprenderán lógica, secuencias y los primeros pasos de la programación por bloques.',
                    'Para ingresar, utiliza tu usuario institucional en el botón "Campus Virtual".',
                ],
            ],
            [
                'slug' => 'jornada-deportiva-institucional',
                'titulo' => 'Jornada deportiva institucional',
                'categoria' => 'Comunidad',
                'fecha' => '2026-09-30',
                'extracto' => 'Estudiantes, docentes y familias compartieron una mañana de deporte y sana convivencia.',
                'contenido' => [
                    'La jornada deportiva reunió a toda la comunidad en torno al juego limpio, el trabajo en equipo y el respeto.',
                    'Hubo torneos de fútbol, baloncesto y atletismo, además de actividades recreativas para los más pequeños.',
                ],
            ],
            [
                'slug' => 'inscripciones-abiertas-2027',
                'titulo' => 'Inscripciones abiertas para el año 2027',
                'categoria' => 'Admisiones',
                'fecha' => '2026-09-12',
                'extracto' => 'Conoce el proceso de admisión y agenda tu visita guiada a nuestras instalaciones.',
                'contenido' => [
                    'Abrimos oficialmente el proceso de admisiones para el año académico 2027 en los niveles de preescolar, primaria y bachillerato.',
                    'Las familias interesadas pueden agendar una visita guiada escribiéndonos desde la sección de contacto.',
                ],
            ],
            [
                'slug' => 'reconocimiento-docentes-destacados',
                'titulo' => 'Reconocimiento a docentes destacados',
                'categoria' => 'Institucional',
                'fecha' => '2026-08-20',
                'extracto' => 'Celebramos la vocación y dedicación de nuestros maestros con una ceremonia especial.',
                'contenido' => [
                    'En una emotiva ceremonia reconocimos a los docentes que se destacaron por su innovación pedagógica y compromiso con los estudiantes.',
                    'Gracias a cada uno de ellos por inspirar a nuestras nuevas generaciones.',
                ],
            ],
            [
                'slug' => 'taller-padres-tecnologia-segura',
                'titulo' => 'Taller para padres: tecnología segura en casa',
                'categoria' => 'Formación',
                'fecha' => '2026-08-05',
                'extracto' => 'Herramientas prácticas para acompañar a los niños y jóvenes en el mundo digital.',
                'contenido' => [
                    'Más de 100 familias participaron en el taller sobre uso responsable de la tecnología y seguridad en internet.',
                    'Los asistentes recibieron una guía con recomendaciones y recursos para aplicar en casa.',
                ],
            ],
        ];

        // Agrega imagen y fecha legible a cada noticia (datos derivados para la vista).
        return array_map(function (array $noticia) {
            $noticia['imagen'] = 'https://placehold.co/800x500/1E5AA8/ffffff?text='.urlencode($noticia['categoria']);
            $noticia['fecha_legible'] = Carbon::parse($noticia['fecha'])
                ->locale('es')
                ->translatedFormat('j \d\e F \d\e Y');

            return $noticia;
        }, $noticias);
    }

    /** Listado de noticias. */
    public function index()
    {
        return view('noticias.index', ['noticias' => self::articulos()]);
    }

    /** Detalle de una noticia por slug (404 si no existe). */
    public function show(string $slug)
    {
        $noticias = self::articulos();
        $noticia = collect($noticias)->firstWhere('slug', $slug);

        abort_if($noticia === null, 404);

        // Otras noticias sugeridas (excluye la actual).
        $relacionadas = collect($noticias)->where('slug', '!=', $slug)->take(3)->all();

        return view('noticias.show', compact('noticia', 'relacionadas'));
    }
}
