<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GameRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'name.*' => 'required',
            'locale.*.title' => 'required|string',
            'locale.*.description' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es obligatorio',
            'locale.*.title.required' => 'El título es obligatorio',
            'locale.*.description.required' => 'La descripción es obligatoria',
        ];
    }
}
