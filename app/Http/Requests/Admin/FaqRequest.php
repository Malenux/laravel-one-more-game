<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FaqRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'active' => 'nullable|boolean',
            'locale.*.question' => 'required|string',
            'locale.*.answer' => 'required|string',
        ];
    }


    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es obligatorio',
            'active.required' => 'El estado es obligatorio',
            'locale.*.question.required' => 'La pregunta es obligatoria',
            'locale.*.answer.required' => 'La respuesta es obligatoria',
        ];
    }
}
