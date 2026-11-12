<?php

namespace App\Http\Requests;

use App\Models\Noticia;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/** Validación para crear y actualizar noticias/comunicados. */
class NoticiaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user()?->esAdmin();
    }

    public function rules(): array
    {
        return [
            'titulo' => ['required', 'string', 'max:150'],
            'tipo' => ['required', Rule::in(array_keys(Noticia::TIPOS))],
            'categoria' => ['required', 'string', 'max:60'],
            'extracto' => ['required', 'string', 'max:220'],
            'cuerpo' => ['required', 'string', 'min:20'],
            'estado' => ['required', Rule::in(array_keys(Noticia::ESTADOS))],
            'publicada_en' => ['required', 'date'],
            'imagen' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'quitar_imagen' => ['sometimes', 'boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'titulo' => 'título',
            'categoria' => 'categoría',
            'cuerpo' => 'contenido',
            'publicada_en' => 'fecha de publicación',
            'imagen' => 'imagen',
        ];
    }

    public function messages(): array
    {
        return [
            'titulo.required' => 'Escribe un título para la publicación.',
            'extracto.required' => 'Escribe un resumen corto: se muestra en las tarjetas del sitio.',
            'extracto.max' => 'El resumen es muy largo. Acórtalo a máximo :max caracteres.',
            'cuerpo.required' => 'Escribe el contenido de la publicación.',
            'cuerpo.min' => 'El contenido es muy corto. Escribe al menos :min caracteres.',
            'imagen.image' => 'El archivo debe ser una imagen (JPG, PNG o WebP).',
            'imagen.mimes' => 'Sube una imagen JPG, PNG o WebP.',
            'imagen.max' => 'La imagen pesa demasiado. Sube una de máximo 2 MB.',
        ];
    }
}
