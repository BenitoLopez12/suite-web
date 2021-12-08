@extends('layouts.admin')
@section('content')

    {{ Breadcrumbs::render('admin.comunicacion-sgis.create') }}

    <style type="text/css">
        .select2-selection--multiple{
        overflow: hidden !important;
        height: auto !important;
}
    </style>

<div class="mt-4 card">
    <div class="py-3 col-md-10 col-sm-9 card-body verde_silent align-self-center" style="margin-top: -40px;">
        <h3 class="mb-1 text-center text-white"><strong> Registrar: </strong> Comunicación SGSI </h3>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.comunicacion-sgis.store") }}" enctype="multipart/form-data" class="row">
            @csrf
            <div class="form-group col-12">
                <label class="required" for="TitulodComunicado"><i class="fas fa-align-left iconos-crear"></i>
                Título del Comunicado</label>
                <input class="form-control {{ $errors->has('TitulodComunicado') ? 'is-invalid' : '' }}" type="text" name="titulo" id="titulo" required value="{{ old('titulo') }}">
                @if($errors->has('dTitulodComunicado'))
                    <div class="invalid-feedback">
                        {{ $errors->first('TitulodComunicado') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.comunicacionSgi.fields.descripcion_helper') }}</span>
            </div>

            <div class="form-group col-12">
                <label class="required" for="descripcion"><i class="fas fa-pencil-ruler iconos-crear"></i>
                Contenido</label>
                <textarea class="form-control {{ $errors->has('descripcion') ? 'is-invalid' : '' }}" name="descripcion" id="descripcion" required>{{ old('descripcion') }}</textarea>
                @if($errors->has('descripcion'))
                    <div class="invalid-feedback">
                        {{ $errors->first('descripcion') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.comunicacionSgi.fields.descripcion_helper') }}</span>
            </div>

            <div class="form-group col-md-6 col-sm-12">
                <label for="documento"><i class="fas fa-folder-open iconos-crear"></i>Cargar Documento</label>
                <input type="file" name="files[]" multiple class="form-control" id="documento" accept="application/pdf" value="{{ old('files[]') }}">
            </div>



            <div class="form-group col-md-6">
                <label class="required" for="imagen"> <i class="fas fa-image iconos-crear"></i>Imagen</label>

                <input type="file" name="imagen" class="form-control" accept="image/*" required value="{{ old('imagen') }}">
                <small>Tamaño recomendado de la imagen 500px por 300px</small>
                @if($errors->has('imagen'))
                    <div class="invalid-feedback">
                         {{ $errors->first('imagen') }}
                    </div>
                @endif
            </div>




            <div class="form-group col-12">
                <label class="required" for="publicar_en"><i class="fab fa-elementor iconos-crear"></i>Publicar en </label>
                <select class="form-control {{ $errors->has('publicar_en') ? 'is-invalid' : '' }}" name="publicar_en" id="publicar_en" required>
                    <option disabled value="{{ old('publicar_en') }}" selected>
                        {{ old('publicar_en') }}
                    </option>
                        @foreach (App\Models\ComunicacionSgi::TipoSelect as $key => $label)
                            <option value="{{ $key }}">
                                {{ $label }}
                            </option>
                        @endforeach
                </select>
                @if ($errors->has('tipo'))
                    <div class="invalid-feedback">
                        {{ $errors->first('publicar_en') }}
                    </div>
                @endif
            </div>

            <div class="col-sm-12 col-md-6 form-group">
                <label class="required" for="publico"><i class="fas fa-people-arrows iconos-crear"></i>Público Objetivo</label>
                <select name="empleados[]" class="select2" multiple required>
                    @foreach($empleados as $empleado)
                        <option value="{{$empleado->id}}">{{$empleado->name}}</option>
                    @endforeach
                </select>
            </div>
            {{-- Select dinamico por grupos --}}
            {{-- <div class="col-12">
                <div class="row justify-content-center align-items-center">
                    <div class="col-9">
                        <label class="mb-0" for="descripcion">
                            <i class="fas fa-users iconos-crear"></i> Público objetivo <small
                                class="text-danger">*</small>
                        </label>
                        <select
                            class="mt-2 form-control {{ $errors->has('evaluados_objetivo') ? 'is-invalid' : '' }}"
                            wire:model="evaluados_objetivo" id="evaluados_objetivo"
                            name="evaluados_objetivo"
                            wire:change="habilitarSelectAlternativo()">
                            <option value="" selected>-- Seleciona una opción --</option>
                            <option value="all">Toda la empresa</option>
                            <option value="area">Por Área</option>
                            @foreach ($grupos_evaluados as $grupo)
                                <option value="{{ $grupo->id }}">{{ $grupo->nombre }} -
                                    Grupo
                                </option>
                            @endforeach
                            <option value="manual">Manualmente</option>
                        </select>
                        @if ($errors->has('evaluados_objetivo'))
                            <div class="invalid-feedback">
                                {{ $errors->first('evaluados_objetivo') }}
                            </div>
                        @endif
                        <span class="errors evaluados_manual_error text-danger"></span>
                        <small id="evaluadosQuestionHelp"
                            class="form-text text-muted">Selecciona a
                            quien(es)
                            va dirigida la
                            evaluación</small>
                        @if ($habilitarSelectAreas)
                            <select
                                class="mt-3 form-control {{ $errors->has('by_area') ? 'is-invalid' : '' }}"
                                id="by_area" wire:model.defer="by_area">
                                <option value="" selected>-- Seleciona el área a evaluar --
                                </option>
                                @foreach ($areas as $area)
                                    <option value="{{ $area->id }}">{{ $area->area }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('by_area'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('by_area') }}
                                </div>
                            @endif
                        @endif
                        @if ($habilitarSelectManual)
                            <label class="m-0 mt-2" for="">Selecciona a los empleados a
                                evaluar</label>
                            <select
                                class="mt-3 form-control {{ $errors->has('by_manual') ? 'is-invalid' : '' }}"
                                multiple id="by_manual" wire:model.defer="by_manual">
                                @foreach ($empleados as $empleado)
                                    <option value="{{ $empleado->id }}">
                                        {{ $empleado->name }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('by_manual'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('by_manual') }}
                                </div>
                            @endif
                            <small class="form-text text-muted">Importante: No se creará un
                                nuevo grupo,esta opción es recomendada para selecciones de una
                                sola vez</small>
                        @endif
                    </div>
                    <div class="col-3" style="margin-top: 0;">
                        @livewire('ev360-grupo-evaluados-create')
                    </div>
                </div>
            </div> --}}



            <div class="col-sm-12 col-md-6 form-group">
                <label class="required" for="link"><i class="fas fa-link iconos-crear"></i>Link</label>
                <input class="form-control {{ $errors->has('link') ? 'is-invalid' : '' }}" type="text" name="link" id="link" value="{{ old('link') }}" required>
                @if($errors->has('link'))
                    <div class="invalid-feedback">
                        {{ $errors->first('link') }}
                    </div>
                @endif
            </div>

            <div class="col-sm-12 col-md-6 form-group">
                <label class="required"><i class="far fa-calendar-alt iconos-crear"></i> Programar fecha de inicio de publicación</label>
                <input class="form-control date {{ $errors->has('fecha_programable') ? 'is-invalid' : '' }}" type="date" name="fecha_programable" value="{{ old('fecha_programable') }}" required>
                 @if($errors->has('fecha_programable'))
                    <div class="invalid-feedback">
                        {{ $errors->first('fecha_programable') }}
                    </div>
                @endif
            </div>


            <div class="col-sm-12 col-md-6 form-group">
                <label><i class="far fa-calendar-alt iconos-crear"></i> Programar fecha de fin de publicación</label>
                <input class="form-control date {{ $errors->has('fecha_programable_fin') ? 'is-invalid' : '' }}" type="date" name="fecha_programable_fin" value="{{ old('fecha_programable_fin') }}">
                 @if($errors->has('fecha_programable_fin'))
                    <div class="invalid-feedback">
                        {{ $errors->first('fecha_programable_fin') }}
                    </div>
                @endif
            </div>


            <div class="text-right form-group col-12"><br>
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
    Dropzone.options.archivoDropzone = {
    url: '{{ route('admin.comunicacion-sgis.storeMedia') }}',
    maxFilesize: 4, // MB
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 4
    },
    success: function (file, response) {
      $('form').find('input[name="archivo"]').remove()
      $('form').append('<input type="hidden" name="archivo" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="archivo"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($comunicacionSgi) && $comunicacionSgi->archivo)
      var file = {!! json_encode($comunicacionSgi->archivo) !!}
          this.options.addedfile.call(this, file)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="archivo" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}
</script>

<script>
    $(document).ready(function() {
        CKEDITOR.replace('descripcion', {
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

    $(document).ready(function(){

  $(".select2").select2({
    theme:"bootstrap4",
  });

});

</script>
@endsection
