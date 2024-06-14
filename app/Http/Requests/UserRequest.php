<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name.required' => 'O Titulo é obrigatório',
            'email' => [
                'nullable',
                'email',
                Rule::unique('users', 'email')->ignore($this->email, 'email')
            ],
            'tipo.required' => 'O ano é obrigatório',
            'foto_url.required' => 'O sumario é obrigatório',

        ];
    }
}
