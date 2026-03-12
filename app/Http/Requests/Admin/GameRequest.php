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
            'title' => 'required|string',
            'title.*' => 'required',
            'description' => 'required|string',
            'description.*' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es obligatorio',
            'title.*.required' => 'El título es obligatorio',
            'description.*.required' => 'La descripción es obligatoria',
        ];
    }
}
