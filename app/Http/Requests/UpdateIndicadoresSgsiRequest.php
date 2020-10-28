<?php

namespace App\Http\Requests;

use App\Models\IndicadoresSgsi;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateIndicadoresSgsiRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('indicadores_sgsi_edit');
    }

    public function rules()
    {
        return [
            'control'    => [
                'string',
                'required',
            ],
            'titulo'     => [
                'string',
                'nullable',
            ],
            'meta'       => [
                'string',
                'nullable',
            ],
            'enero'      => [
                'numeric',
                'min:0',
                'max:100',
            ],
            'febrero'    => [
                'numeric',
                'min:0',
                'max:100',
            ],
            'marzo'      => [
                'numeric',
                'min:0',
                'max:100',
            ],
            'abril'      => [
                'numeric',
                'min:0',
                'max:100',
            ],
            'mayo'       => [
                'numeric',
                'min:0',
                'max:100',
            ],
            'junio'      => [
                'numeric',
                'min:0',
                'max:100',
            ],
            'julio'      => [
                'numeric',
                'min:0',
                'max:100',
            ],
            'agosto'     => [
                'numeric',
                'min:0',
                'max:100',
            ],
            'septiembre' => [
                'numeric',
                'min:0',
                'max:100',
            ],
            'octubre'    => [
                'numeric',
                'min:0',
                'max:100',
            ],
            'noviembre'  => [
                'numeric',
                'min:0',
                'max:100',
            ],
            'diciembre'  => [
                'numeric',
                'min:0',
                'max:100',
            ],
            'anio'       => [
                'string',
                'min:4',
                'max:4',
                'nullable',
            ],
        ];
    }
}
