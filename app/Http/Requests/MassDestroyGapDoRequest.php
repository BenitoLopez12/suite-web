<?php

namespace App\Http\Requests;

use App\Models\GapDo;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyGapDoRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('gap_do_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:gap_dos,id',
        ];
    }
}
