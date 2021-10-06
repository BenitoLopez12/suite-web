<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreGapDoRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('gap_do_create');
    }

    public function rules()
    {
        return [
            'anexo_indice'        => [
                'string',
                'nullable',
            ],
            'control'             => [
                'string',
                'nullable',
            ],
            'descripcion_control' => [
                'string',
                'nullable',
            ],
            'evidencia'           => [
                'string',
                'nullable',
            ],
            'recomendacion'       => [
                'string',
                'nullable',
            ],
        ];
    }
}
