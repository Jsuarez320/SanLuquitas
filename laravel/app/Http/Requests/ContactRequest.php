<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validación del formulario de contacto.
 */
class ContactRequest extends FormRequest
{
    /** El formulario es público. */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'min:3', 'max:100'],
            'correo' => ['required', 'email:rfc', 'max:150'],
            'asunto' => ['required', 'string', 'min:3', 'max:150'],
            'mensaje' => ['required', 'string', 'min:10', 'max:2000'],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'El campo :attribute es obligatorio.',
            'email' => 'Ingresa un correo electrónico válido.',
            'min' => 'El campo :attribute debe tener al menos :min caracteres.',
            'max' => 'El campo :attribute no puede superar :max caracteres.',
        ];
    }

    public function attributes(): array
    {
        return [
            'nombre' => 'nombre',
            'correo' => 'correo',
            'asunto' => 'asunto',
            'mensaje' => 'mensaje',
        ];
    }
}
