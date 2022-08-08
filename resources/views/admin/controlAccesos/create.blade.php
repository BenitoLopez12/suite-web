@extends('layouts.admin')
@section('content')

    {{ Breadcrumbs::render('admin.control-accesos.create') }}
<h5 class="col-12 titulo_general_funcion">Registrar: Control de Acceso</h5>
<div class="card mt-4">
    <div class="card-body">
        <form method="POST" action="{{ route("admin.control-accesos.store") }}" enctype="multipart/form-data" class="row">
            @csrf

                <div class="form-group col-sm-12">
                    <label class="required" for="tipo"><i class="fas fa-user-lock iconos-crear"></i>
                        Tipo de acceso</label>
                    <div style="float: right;">
                        <button id="btnAgregarTipo" onclick="event.preventDefault();"
                            class="text-white btn btn-sm" style="background:#3eb2ad;height: 32px;"
                            data-toggle="modal" data-target="#tipoCompetenciaModal" data-whatever="@mdo"
                            data-whatever="@mdo" title="Agregar tipo de permiso"><i
                                class="fas fa-plus"></i></button>
                        <a href="{{ route('admin.tipo-acceso.index') }}" class="text-white btn btn-sm" style="background:#3eb2ad;height: 32px;"><i
                        class="fas fa-edit"></i></a>
                    </div>
                    @livewire('permiso-component')
                    @livewire('tipo-permiso-select-component')

                </div>

                <div class="form-group col-sm-4 mt-3">
                    <div class="form-group">
                        <label for='responsable_id'><i
                                class="fas fa-user-tie iconos-crear"></i>Responsable</label>
                        <select
                            class="form-control select2 {{ $errors->has('responsable_id') ? 'is-invalid' : '' }}"
                            name='responsable_id' id='responsable_id'>
                            <option value="">Seleccione un responsable</option>
                            @foreach ($responsables as $responsable)
                                <option value="{{ $responsable->id }}"
                                    data-area="{{ $responsable->area->area }}"
                                    data-puesto="{{ $responsable->puesto }}">
                                    {{ $responsable->name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('responsable_id'))
                            <div class="invalid-feedback">
                                {{ $errors->first('responsable_id') }}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="form-group col-md-4 mt-3">
                    <label><i class="fas fa-briefcase iconos-crear"></i>Puesto<sup>*</sup></label>
                    <div class="form-control" id="responsable_puesto" readonly></div>
                </div>


                <div class="form-group col-sm-12 col-md-4 col-lg-4 mt-3">
                    <label><i class="fas fa-street-view iconos-crear"></i>Área<sup>*</sup></label>
                    <div class="form-control" id="responsable_area" readonly></div>
                </div>

            <div class=" mb-4 ml-3 w-100" style="border-bottom: solid 2px #345183;">
                <span style="font-size: 17px; font-weight: bold;">
                    Periodo</span>
            </div>

            <div class="form-group col-sm-12 col-md-12 col-lg-6">
                <label for="fecha_inicio">
                    <i class="fas fa-calendar-alt iconos-crear"></i>
                    Fecha Fin
                </label>
                <input class="form-control" type="date" id="fecha_inicio" name="fecha_inicio"
                    value="{{ old('fecha_inicio')}}">
                <span class="fecha_inicio_error text-danger errores"></span>
                @if ($errors->has('fecha_inicio'))
                    <div class="invalid-feedback">
                        {{ $errors->first('fecha_inicio') }}
                    </div>
                @endif
            </div>

            <div class="form-group col-sm-12 col-md-12 col-lg-6">
                <label for="fecha_fin">
                    <i class="fas fa-calendar-alt iconos-crear"></i>
                    Fecha Fin
                </label>
                <input class="form-control" type="date" id="fecha_fin" name="fecha_fin"
                    value="{{ old('fecha_fin') }}">
                <span class="fecha_fin_error text-danger errores"></span>
                @if ($errors->has('fecha_fin'))
                    <div class="invalid-feedback">
                        {{ $errors->first('fecha_fin') }}
                    </div>
                @endif
            </div>
            
            <div class="form-group col-md-12">
                <label><i class="fas fa-align-left iconos-crear"></i>Justificación</label>
                <textarea class="form-control {{ $errors->has('justificacion') ? 'is-invalid' : '' }}" name="justificacion" id="justificacion">{{ old('justificacion') }}</textarea>
                @if($errors->has('justificacion'))
                    <div class="invalid-feedback">
                        {{ $errors->first('justificacion') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.controlAcceso.fields.descripcion_helper') }}</span>
            </div>

            <div class="form-group col-md-12">
                <label for="descripcion"><i class="fas fa-file-alt iconos-crear"></i>{{ trans('cruds.controlAcceso.fields.descripcion') }}</label>
                <textarea class="form-control {{ $errors->has('descripcion') ? 'is-invalid' : '' }}" name="descripcion" id="descripcion">{{ old('descripcion') }}</textarea>
                @if($errors->has('descripcion'))
                    <div class="invalid-feedback">
                        {{ $errors->first('descripcion') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.controlAcceso.fields.descripcion_helper') }}</span>
            </div>


            <div class="form-group col-12">
                <label for="documento"><i class="fas fa-folder-open iconos-crear"></i>Archivo</label>
                <input type="file" name="files[]" multiple class="form-control" id="documento" accept="application/pdf" value="{{ old('files[]') }}">
            </div>

            {{-- <div class="form-group col-md-12">
                <label for="archivo"><i class="far fa-file iconos-crear"></i>{{ trans('cruds.controlAcceso.fields.archivo') }}</label>
                <div class="needsclick dropzone {{ $errors->has('archivo') ? 'is-invalid' : '' }}" id="archivo-dropzone">
                </div>
                @if($errors->has('archivo'))
                    <div class="invalid-feedback">
                        {{ $errors->first('archivo') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.controlAcceso.fields.archivo_helper') }}</span>
            </div> --}}


            <div class="form-group col-12 text-right">
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
    url: '{{ route('admin.control-accesos.storeMedia') }}',
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
@if(isset($controlAcceso) && $controlAcceso->archivo)
      var file = {!! json_encode($controlAcceso->archivo) !!}
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
    if (document.querySelector('#responsable_id') != null) {

        let responsable = document.querySelector('#responsable_id');
        let area_init = responsable.options[responsable.selectedIndex].getAttribute('data-area');
        let puesto_init = responsable.options[responsable.selectedIndex].getAttribute('data-puesto');
        document.getElementById('responsable_puesto').innerHTML = recortarTexto(puesto_init);
        document.getElementById('responsable_area').innerHTML = recortarTexto(area_init);

        responsable.addEventListener('change', function(e) {
            e.preventDefault();
            let area = e.target.options[e.target.selectedIndex].getAttribute('data-area');
            let puesto = e.target.options[e.target.selectedIndex].getAttribute('data-puesto');
            console.log(e.target.options[e.target.selectedIndex]);
            document.getElementById('responsable_puesto').innerHTML = recortarTexto(puesto)
            document.getElementById('responsable_area').innerHTML = recortarTexto(area)
        })
    }

    function recortarTexto(texto, length = 30) {
        let trimmedString = texto?.length > length ?
            texto.substring(0, length - 3) + "..." :
            texto;
        return trimmedString;
    }
</script>
@endsection