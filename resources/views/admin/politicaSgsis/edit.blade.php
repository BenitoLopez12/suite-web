@extends('layouts.admin')
@section('content')

    {{ Breadcrumbs::render('admin.politica-sgsis.create') }}

<div class="mt-4 card">
    <div class="py-3 col-md-10 col-sm-9 card-body azul_silent align-self-center" style="margin-top: -40px;">
        <h3 class="mb-1 text-center text-white"><strong> Editar: </strong> Política SGSI </h3>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.politica-sgsis.update", [$politicaSgsi->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="politicasgsi"><i class="fas fa-landmark iconos-crear"></i>Política del Sistema de Gestión de Seguridad de la Información (SGSI)</label>
                <textarea class="form-control {{ $errors->has('politicasgsi') ? 'is-invalid' : '' }}" name="politicasgsi" id="politicasgsi">{{ old('politicasgsi', $politicaSgsi->politicasgsi) }}</textarea>
                @if($errors->has('politicasgsi'))
                    <div class="invalid-feedback">
                        {{ $errors->first('politicasgsi') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.politicaSgsi.fields.politicasgsi_helper') }}</span>
            </div>

            <div class="row">
                <div class="form-group col-sm-4">
                    <label for="fecha_publicacion"><i class="far fa-calendar-alt iconos-crear"></i>Fecha de
                        publicación</label>
                    <input class="form-control date  {{ $errors->has('fecha_publicacion') ? 'is-invalid' : '' }}"
                        type="date" name="fecha_publicacion" id="fecha_publicacion"
                        value="{{ old('fecha_publicacion',\Carbon\Carbon::parse($politicaSgsi->fecha_publicacion))->format('Y-m-d') }}">
                    @if ($errors->has('fecha_publicacion'))
                        <div class="invalid-feedback">
                            {{ $errors->first('fecha_publicacion') }}
                        </div>
                    @endif
                </div>

                <div class="form-group col-sm-4">
                    <label for="fecha_entrada"><i class="far fa-calendar-alt iconos-crear"></i>Fecha de
                        verificación</label>
                    <input class="form-control date {{ $errors->has('fecha_entrada') ? 'is-invalid' : '' }}"
                        type="date" name="fecha_entrada" id="fecha_entrada"
                        value="{{ old('fecha_entrada',\Carbon\Carbon::parse($politicaSgsi->fecha_entrada))->format('Y-m-d') }}">
                    @if ($errors->has('fecha_entrada'))
                        <div class="invalid-feedback">
                            {{ $errors->first('fecha_entrada') }}
                        </div>
                    @endif
                </div>

                <div class="form-group col-sm-4">
                    <label for="fecha_revision"><i class="far fa-calendar-alt iconos-crear"></i>Fecha de
                        revisión</label>
                    <input class="form-control date {{ $errors->has('fecha_revision') ? 'is-invalid' : '' }}"
                        type="date" name="fecha_revision" id="fecha_revision"
                        value="{{ old('fecha_revision',\Carbon\Carbon::parse($politicaSgsi->fecha_revision))->format('Y-m-d') }}">
                    @if ($errors->has('fecha_revision'))
                        <div class="invalid-feedback">
                            {{ $errors->first('fecha_revision') }}
                        </div>
                    @endif
                </div>

            </div>

            <div class="row">
                <div class="mt-1 form-group col-12">
                    <b>Revisó política:</b>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-4">
                    <label for="id_reviso_politica"><i class="fas fa-user-tie iconos-crear"></i>Nombre</label>
                    <select class="form-control select2 {{ $errors->has('id_reviso_politica') ? 'is-invalid' : '' }}" name="id_reviso_politica" id="id_reviso_politica">
                        @foreach ($empleados as $empleado)
                        <option {{old('id_reviso_politica',$politicaSgsi->id_reviso_politica) ==$empleado->id ?'selected' : ''}} data-puesto="{{ $empleado->puesto }}" value="{{ $empleado->id }}" data-area="{{ $empleado->area->area }}">

                            {{ $empleado->name }}
                        </option>

                        @endforeach
                    </select>
                    @if ($errors->has('id_reviso_politica'))
                    <div class="invalid-feedback">
                        {{ $errors->first('id_reviso_politica') }}
                    </div>
                    @endif
                </div>


                <div class="form-group col-sm-12 col-md-4 col-lg-4">
                    <label for="id_puesto_reviso"><i class="fas fa-briefcase iconos-crear"></i>Puesto</label>
                    <div class="form-control" id="puesto_reviso"></div>

                </div>


                <div class="form-group col-sm-12 col-md-4 col-lg-4">
                    <label for="id_area_reviso"><i class="fas fa-street-view iconos-crear"></i>Área</label>
                    <div class="form-control" id="area_reviso"></div>

                </div>

            </div>


            <div class="text-right form-group col-12">
                <a href="{{ redirect()->getUrlGenerator()->previous() }}" class="btn_cancelar">Cancelar</a>
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection


@section('scripts')
<script>
    $(document).ready(function() {
        CKEDITOR.replace('politicasgsi', {
            toolbar: [{
                        name: 'styles',
                        items: ['Styles', 'Format', 'Font', 'FontSize']
                    },
                    {
                        name: 'colors',
                        items: ['TextColor', 'BGColor']
                    },
                    {
                        name: 'editing',
                        groups: ['find', 'selection', 'spellchecker'],
                        items: ['Find', 'Replace', '-', 'SelectAll', '-', 'Scayt']
                    }, {
                        name: 'clipboard',
                        groups: ['undo'],
                        items: ['Undo', 'Redo']
                    },
                    {
                        name: 'tools',
                        items: ['Maximize']
                    },
                    {
                        name: 'basicstyles',
                        groups: ['basicstyles', 'cleanup'],
                        items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-',
                            'CopyFormatting', 'RemoveFormat'
                        ]
                    },
                    {
                        name: 'paragraph',
                        groups: ['list', 'indent', 'blocks', 'align', 'bidi'],
                        items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote',
                            '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight',
                            'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language'
                        ]
                    },
                    {
                        name: 'links',
                        items: ['Link', 'Unlink']
                    },
                    {
                        name: 'insert',
                        items: ['Table', 'HorizontalRule', 'Smiley', 'SpecialChar']
                    },
                    '/',


                    // {
                    //     name: 'others',
                    //     items: ['-']
                    // }
                ]
        });

    });

</script>

<script>
    document.addEventListener('DOMContentLoaded', function(e) {

        let reviso_politica = document.querySelector('#id_reviso_politica');
        let area_init = reviso_politica.options[reviso_politica.selectedIndex].getAttribute('data-area');
        let puesto_init = reviso_politica.options[reviso_politica.selectedIndex].getAttribute('data-puesto');

        document.getElementById('puesto_reviso').innerHTML = puesto_init;
        document.getElementById('area_reviso').innerHTML = area_init;
        reviso_politica.addEventListener('change', function(e) {
            e.preventDefault();
            let area = this.options[this.selectedIndex].getAttribute('data-area');
            let puesto = this.options[this.selectedIndex].getAttribute('data-puesto');
            document.getElementById('puesto_reviso').innerHTML = puesto;
            document.getElementById('area_reviso').innerHTML = area;
        })

    })
</script>
@endsection
