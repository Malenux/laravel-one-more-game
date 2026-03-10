<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->input('id');

        return [
            'id'                    => 'nullable|exists:customers,id',
            'name'                  => 'required|min:3|max:64|regex:/^[\pL\s\'-]+$/u',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('customers', 'email')
                    ->whereNull('deleted_at')
                    ->ignore($id),
            ],
            'password'              => 'nullable|required_without:id|min:6',
            'password_confirmation' => 'nullable|required_without:id|same:password',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'                          => 'El nombre es obligatorio',
            'name.min'                               => 'El mínimo de caracteres permitidos para el nombre son 3',
            'name.max'                               => 'El máximo de caracteres permitidos para el nombre son 64',
            'name.regex'                             => 'Sólo se aceptan letras y caracteres válidos para el nombre',
            'email.required'                         => 'El email es obligatorio',
            'email.email'                            => 'El formato de email es incorrecto',
            'email.max'                              => 'El máximo de caracteres permitidos para el email son 255',
            'email.unique'                           => 'El email ya existe',
            'password.required_without'              => 'La contraseña es obligatoria',
            'password.min'                           => 'La contraseña debe tener al menos 6 caracteres',
            'password_confirmation.required_without' => 'Añada la confirmación de la contraseña',
            'password_confirmation.same'             => 'Las contraseñas no coinciden',
        ];
    }
}