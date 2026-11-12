<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Noticia o comunicado institucional.
 *
 * Los accesores (fecha, fecha_legible, imagen, contenido) replican la forma de
 * los arreglos que usaban las vistas públicas, así que se pueden leer como
 * $noticia['titulo'] sin tocar esas vistas.
 */
#[Fillable(['titulo', 'slug', 'tipo', 'categoria', 'extracto', 'cuerpo', 'imagen_path', 'estado', 'publicada_en', 'user_id'])]
class Noticia extends Model
{
    public const TIPOS = ['noticia' => 'Noticia', 'comunicado' => 'Comunicado'];

    public const ESTADOS = ['borrador' => 'Borrador', 'publicado' => 'Publicado'];

    protected $table = 'noticias';

    protected function casts(): array
    {
        return ['publicada_en' => 'date'];
    }

    protected static function booted(): void
    {
        static::creating(function (Noticia $noticia) {
            $noticia->slug = $noticia->slug ?: self::slugUnico($noticia->titulo);
        });
    }

    public static function slugUnico(string $titulo): string
    {
        $base = Str::slug($titulo) ?: 'publicacion';
        $slug = $base;
        $n = 2;

        while (static::where('slug', $slug)->exists()) {
            $slug = $base.'-'.$n++;
        }

        return $slug;
    }

    public function autor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /** Visibles en el sitio: publicadas y con fecha ya cumplida. */
    public function scopePublicadas($query)
    {
        return $query->where('estado', 'publicado')
            ->whereDate('publicada_en', '<=', now())
            ->orderByDesc('publicada_en')
            ->orderByDesc('id');
    }

    public function estaPublicada(): bool
    {
        return $this->estado === 'publicado';
    }

    protected function fecha(): Attribute
    {
        return Attribute::get(fn () => $this->publicada_en->toDateString());
    }

    protected function fechaLegible(): Attribute
    {
        return Attribute::get(fn () => $this->publicada_en->locale('es')->translatedFormat('j \d\e F \d\e Y'));
    }

    protected function imagen(): Attribute
    {
        return Attribute::get(fn () => $this->imagen_path
            ? Storage::disk('public')->url($this->imagen_path)
            : 'https://placehold.co/800x500/1E5AA8/ffffff?text='.urlencode($this->categoria));
    }

    /** Cuerpo dividido en párrafos (líneas en blanco). */
    protected function contenido(): Attribute
    {
        return Attribute::get(fn () => array_values(array_filter(
            preg_split('/\R{2,}/', trim($this->cuerpo)),
            fn ($p) => trim($p) !== '',
        )));
    }
}
