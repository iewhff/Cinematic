<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilmesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): array
    {
        return [
            'titulo' =>        'required',
            'genero_code' =>   'required',
            'ano' =>           'required',
            'sumario' =>       'required',

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
            'titulo.required' => 'O Titulo é obrigatório',
            'genero_code.required' => 'O genero é obrigatório',
            'ano.required' => 'O ano é obrigatório',
            'sumario.required' => 'O sumario é obrigatório',

        ];
    }
}
