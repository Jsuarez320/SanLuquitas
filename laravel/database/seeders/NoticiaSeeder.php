<?php

namespace Database\Seeders;

use App\Models\Noticia;
use Illuminate\Database\Seeder;

/** Noticias de ejemplo del sitio (antes estaban fijas en el controlador). */
class NoticiaSeeder extends Seeder
{
    public function run(): void
    {
        $noticias = [
            ['feria-de-ciencias-2026', 'Gran Feria de Ciencias 2026', 'noticia', 'Académico', '2026-10-28',
                'Más de 80 proyectos de nuestros estudiantes se presentaron ante la comunidad educativa.', [
                    'Con enorme entusiasmo se realizó la Feria de Ciencias 2026, donde estudiantes de todos los niveles presentaron proyectos de robótica, medio ambiente y salud.',
                    'Los trabajos fueron evaluados por un jurado de docentes y padres de familia invitados, quienes destacaron la creatividad y el rigor investigativo.',
                    'Agradecemos a las familias por su acompañamiento y felicitamos a todos los participantes.',
                ]],
            ['nuevo-curso-programacion-primaria', 'Nuevo curso virtual: Programación Primaria', 'noticia', 'Campus Virtual', '2026-10-15',
                'Ya está disponible en el Campus Virtual el curso que introduce el pensamiento computacional.', [
                    'Los estudiantes de primaria ya pueden acceder al curso "Programación Primaria" en nuestro Campus Virtual.',
                    'A través de retos y actividades lúdicas aprenderán lógica, secuencias y los primeros pasos de la programación por bloques.',
                    'Para ingresar, utiliza tu usuario institucional en el botón "Campus Virtual".',
                ]],
            ['jornada-deportiva-institucional', 'Jornada deportiva institucional', 'noticia', 'Comunidad', '2026-09-30',
                'Estudiantes, docentes y familias compartieron una mañana de deporte y sana convivencia.', [
                    'La jornada deportiva reunió a toda la comunidad en torno al juego limpio, el trabajo en equipo y el respeto.',
                    'Hubo torneos de fútbol, baloncesto y atletismo, además de actividades recreativas para los más pequeños.',
                ]],
            ['inscripciones-abiertas-2027', 'Inscripciones abiertas para el año 2027', 'comunicado', 'Admisiones', '2026-09-12',
                'Conoce el proceso de admisión y agenda tu visita guiada a nuestras instalaciones.', [
                    'Abrimos oficialmente el proceso de admisiones para el año académico 2027 en los niveles de preescolar, primaria y bachillerato.',
                    'Las familias interesadas pueden agendar una visita guiada escribiéndonos desde la sección de contacto.',
                ]],
            ['reconocimiento-docentes-destacados', 'Reconocimiento a docentes destacados', 'noticia', 'Institucional', '2026-08-20',
                'Celebramos la vocación y dedicación de nuestros maestros con una ceremonia especial.', [
                    'En una emotiva ceremonia reconocimos a los docentes que se destacaron por su innovación pedagógica y compromiso con los estudiantes.',
                    'Gracias a cada uno de ellos por inspirar a nuestras nuevas generaciones.',
                ]],
            ['taller-padres-tecnologia-segura', 'Taller para padres: tecnología segura en casa', 'noticia', 'Formación', '2026-08-05',
                'Herramientas prácticas para acompañar a los niños y jóvenes en el mundo digital.', [
                    'Más de 100 familias participaron en el taller sobre uso responsable de la tecnología y seguridad en internet.',
                    'Los asistentes recibieron una guía con recomendaciones y recursos para aplicar en casa.',
                ]],
            // Para probar el panel: comunicados, borradores y una publicación programada.
            ['comunicado-horario-semana-santa', 'Horario especial por Semana Santa', 'comunicado', 'Institucional', '2026-11-05',
                'Informamos los días sin actividades académicas y el reintegro a clases.', [
                    'Estimadas familias: durante la Semana Santa no habrá actividades académicas ni servicio de transporte.',
                    'Las clases se reanudan con normalidad el lunes siguiente en el horario habitual.',
                ]],
            ['comunicado-reunion-padres-noviembre', 'Reunión general de padres de familia', 'comunicado', 'Comunidad', '2026-11-10',
                'Citación para la entrega de informes del cuarto periodo.', [
                    'Se convoca a todos los padres de familia a la reunión general de entrega de informes del cuarto periodo.',
                    'La asistencia es importante: se compartirán los resultados y las recomendaciones para el cierre del año.',
                ]],
            ['borrador-ceremonia-graduacion-2026', 'Ceremonia de graduación 2026', 'noticia', 'Institucional', '2026-11-20',
                'Detalles de la ceremonia de grado de los estudiantes de undécimo.', [
                    'Estamos preparando la ceremonia de graduación de la promoción 2026. Pronto compartiremos fecha, lugar y programa.',
                    'Pendiente: confirmar invitados y horario con la rectoría.',
                ], 'borrador'],
            ['borrador-nuevo-laboratorio-robotica', 'Nuevo laboratorio de robótica', 'noticia', 'Académico', '2026-11-25',
                'El colegio estrena un espacio dedicado a la robótica y la programación.', [
                    'Con el apoyo de la comunidad educativa inauguramos un laboratorio de robótica equipado para todos los niveles.',
                    'Texto en revisión: falta agregar fotos y el calendario de uso.',
                ], 'borrador'],
            ['programada-feria-del-libro-2027', 'Feria del libro 2027', 'noticia', 'Comunidad', '2027-03-15',
                'Anunciamos la próxima feria del libro con invitados especiales.', [
                    'La feria del libro volverá en marzo con talleres de lectura, autores invitados y venta de libros.',
                    'Esta publicación está programada y se verá en el sitio a partir de su fecha.',
                ]],
        ];

        foreach ($noticias as $fila) {
            // El 8.º valor (estado) es opcional: por defecto "publicado".
            [$slug, $titulo, $tipo, $categoria, $fecha, $extracto, $parrafos, $estado] = array_pad($fila, 8, 'publicado');

            Noticia::firstOrCreate(['slug' => $slug], [
                'titulo' => $titulo,
                'tipo' => $tipo,
                'categoria' => $categoria,
                'extracto' => $extracto,
                'cuerpo' => implode("\n\n", $parrafos),
                'estado' => $estado,
                'publicada_en' => $fecha,
            ]);
        }
    }
}
