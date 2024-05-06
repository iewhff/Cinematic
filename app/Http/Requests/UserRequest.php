<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): array
    {
        return [
            'name' =>        'required',
            'email' =>   'required',
            'tipo' =>           'required',
            'foto_url' =>       'required',

        ];
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
            'email.required' => 'O genero é obrigatório',
            'tipo.required' => 'O ano é obrigatório',
            'foto_url.required' => 'O sumario é obrigatório',

        ];
    }
}
