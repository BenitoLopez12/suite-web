<?php

namespace App\Http\Requests;

use App\Models\EvidenciasSgsi;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyEvidenciasSgsiRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('evidencias_sgsi_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:evidencias_sgsis,id',
        ];
    }
}
