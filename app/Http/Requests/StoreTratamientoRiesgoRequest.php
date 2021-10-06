<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreTratamientoRiesgoRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('tratamiento_riesgo_create');
    }

    public function rules()
    {
        return [
            'nivelriesgo'         => [
                'string',
                'nullable',
            ],
            'fechacompromiso'     => [
                'date:',
                'nullable',
            ],
            'estatus'             => [
                'string',
                'nullable',
            ],
            'probabilidad'        => [
                'string',
                'nullable',
            ],
            'impacto'             => [
                'string',
                'nullable',
            ],
            'nivelriesgoresidual' => [
                'string',
                'nullable',
            ],
        ];
    }
}
