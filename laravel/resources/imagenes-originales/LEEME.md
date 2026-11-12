# Imágenes originales

Fuentes en alta resolución (2–3 MB). **No se sirven al sitio**: viven fuera de `public/`.
Las versiones optimizadas están en `public/images/`:

| Original | Versión web |
|---|---|
| `Logo.png` | `public/images/marca/isotipo.png` (recortado) y los favicons en `public/` |
| `Nosotros.png` | `public/images/nosotros/historia.webp` |
| `Rectora.png`, `Academico.png`, `Convivencia.png`, `Director.png` | `public/images/nosotros/equipo/*.webp` (recortados a rostro y torso) |

| `noticias/01-…png` a `11-…png` | `public/images/noticias/<nombre>.webp` (1000 px). Se asignan a cada noticia en `database/seeders/NoticiaSeeder.php` |

Las noticias creadas desde el admin guardan su imagen aparte (`storage/app/public/noticias`).

La foto de la fachada del hero (`public/images/inicio/fachada.jpg`) ya es liviana y se usa tal cual.
