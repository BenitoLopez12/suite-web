<?php

namespace App\Http\Requests;

use App\Models\MaterialSgsi;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyMaterialSgsiRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('material_sgsi_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:material_sgsis,id',
        ];
    }
}
