@extends('layouts.admin')
@section('content')

<link rel="stylesheet" type="text/css" href="{{ asset('../css/colores.css') }}">
<script src="https://cdn.ckeditor.com/4.17.1/full-all/ckeditor.js"></script>

<style>

.btn .btn-danger{
    background-color: #3e223d !important;
}

</style>

<div class="mt-4 card">
    <div class="py-3 col-md-10 col-sm-9 card-body verde_silent align-self-center" style="margin-top: -40px;">
        <h3 class="mb-1 text-center text-white align-items-centera"><strong> Registrar: </strong>Mi organización </h3>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.organizacions.store") }}" enctype="multipart/form-data" class="row">
            @csrf


            <div class="col-md-12 col-sm-12">
                <div class="card vrd-agua">
                    <p class="mb-1 text-center text-white">DATOS GENERALES</p>
                </div>
            </div>


            <div class="form-group col-sm-12">
                <label class="required" for="empresa"><i class="far fa-building iconos-crear"></i> Nombre de la Empresa</label>
                <input class="form-control {{ $errors->has('empresa') ? 'is-invalid' : '' }}" type="text" name="empresa" id="empresa" value="{{ old('empresa', '') }}" required>
                @if($errors->has('empresa'))
                    <div class="invalid-feedback">
                        {{ $errors->first('empresa') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.organizacion.fields.empresa_helper') }}</span>
            </div>
            <div class="form-group col-sm-12">
                <label class="required" for="direccion"> <i class="fas fa-map-marker-alt iconos-crear"></i> {{ trans('cruds.organizacion.fields.direccion') }}</label>
                <textarea class="form-control {{ $errors->has('direccion') ? 'is-invalid' : '' }}" name="direccion" id="direccion" required style="min-height: 0px; max-height: 200px; height: 35px;">{{ old('direccion') }}</textarea>
                @if($errors->has('direccion'))
                    <div class="invalid-feedback">
                        {{ $errors->first('direccion') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.organizacion.fields.direccion_helper') }}</span>
            </div>
            <div class="form-group col-sm-4">
                <label class="" for="razon_social"><i class="far fa-building iconos-crear"></i> Razón Social</label>
                <input class="form-control {{ $errors->has('razon_social') ? 'is-invalid' : '' }}" type="text" name="razon_social" id="razon_social" value="{{ old('razon_social', '') }}">
                @if($errors->has('razon_social'))
                    <div class="invalid-feedback">
                        {{ $errors->first('razon_social') }}
                    </div>
                @endif
                {{-- <span class="help-block">{{ trans('cruds.organizacion.fields.empresa_helper') }}</span> --}}
            </div>
            <div class="form-group col-sm-4">
                <label class="" for="rfc"><i class="fas fa-file-alt iconos-crear"></i>RFC</label>
                <input class="form-control {{ $errors->has('empresa') ? 'is-invalid' : '' }}" type="text" name="rfc" id="rfc" value="{{ old('rfc', '') }}" >
                @if($errors->has('rfc'))
                    <div class="invalid-feedback">
                        {{ $errors->first('rfc') }}
                    </div>
                @endif
                {{-- <span class="help-block">{{ trans('cruds.organizacion.fields.empresa_helper') }}</span> --}}
            </div>
            <div class="form-group col-sm-4">
                <label for="telefono"> <i class="fas fa-phone iconos-crear"></i> Teléfono</label>
                <input class="form-control {{ $errors->has('telefono') ? 'is-invalid' : '' }}" type="number" name="telefono" id="telefono" value="{{ old('telefono', '') }}" step="1">
                @if($errors->has('telefono'))
                    <div class="invalid-feedback">
                        {{ $errors->first('telefono') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.organizacion.fields.telefono_helper') }}</span>
            </div>
            <div class="form-group col-sm-6">
                <label for="correo"> <i class="far fa-envelope iconos-crear"></i> {{ trans('cruds.organizacion.fields.correo') }}</label>
                <input class="form-control {{ $errors->has('correo') ? 'is-invalid' : '' }}" type="email" name="correo" id="correo" value="{{ old('correo') }}">
                @if($errors->has('correo'))
                    <div class="invalid-feedback">
                        {{ $errors->first('correo') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.organizacion.fields.correo_helper') }}</span>
            </div>
            <div class="form-group col-sm-6">
                <label for="pagina_web"> <i class="fas fa-pager iconos-crear"></i> Página Web</label>
                <input class="form-control {{ $errors->has('pagina_web') ? 'is-invalid' : '' }}" type="text" name="pagina_web" id="pagina_web" value="{{ old('pagina_web', '') }}">
                @if($errors->has('pagina_web'))
                    <div class="invalid-feedback">
                        {{ $errors->first('pagina_web') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.organizacion.fields.pagina_web_helper') }}</span>
            </div>

            <div class="form-group col-12">
                <table class="table" id="user_table">
                    <tbody>
                        <div class=" row col-12 p-0 m-0">
                            <label class="col-md-3 col-sm-3" for="working_day" style="text-align: center;"><i class="fas fa-calendar-alt iconos-crear"></i>Día Laboral</label>
                            <label class="col-md-3 col-sm-3" for="working_day" style="text-align: center;"><i class="fas fa-clock iconos-crear"></i>Horario Laboral Inicio</label>
                            <label class="col-md-3 col-sm-3" for="working_day" style="text-align: center;"><i class="fas fa-clock iconos-crear"></i>Horario Laboral Fin</label>
                            <label class="col-md-3 col-sm-3" for="working_day" style="text-align: center;"></i>Opciones</label>
                        </div>
                    </tbody>
                    <tfoot></tfoot>
                </table>
            </div>
            {{-- <div class="campos form-group col-12" x-data="{ show: false }"> --}}
                {{-- <button type="button" class="btn btn-light" style="margin-bottom: 20px;" @click="show = !show" :aria-expanded="show ? 'true' : 'false'" :class="{ 'active': show }">
                Click para Registrar Horario Laboral  x-show="show"
                </button> --}}
                {{-- <div class="row clon">
                    <div class="form-group col-md-3 col-sm-3 ">
                        <label for="working_day"><i class="fas fa-user-tie iconos-crear"></i>Día Laboral</label><br>
                        <select class="responsableSelect form-control" name="working[0][day][]" id="working_day">
                            <option value="">Seleccione una opción</option>
                            @foreach ($dias as $item)
                                <option  value="{{ $item }}" >{{ $item }}
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('working_day'))
                            <div class="invalid-feedback">
                                {{ $errors->first('working_day') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group col-sm-3">
                        <label class="" for="start_work_time"><i class="fas fa-user-clock iconos-crear"></i>Horario Laboral Inicio</label>
                        <input class="form-control {{ $errors->has('start_work_time') ? 'is-invalid' : '' }}" type="time" name="working[0][start_time][]" id="start_work_time" value="{{ old('start_work_time', '') }}" >
                        @if($errors->has('start_work_time'))
                            <div class="invalid-feedback">
                                {{ $errors->first('start_work_time') }}
                            </div>
                        @endif

                    </div>
                    <div class="form-group col-sm-3">
                        <label class="end_work_time" for="end_work_time"><i class="fas fa-user-clock iconos-crear"></i>Horario Laboral Fin</label>
                        <input class="form-control {{ $errors->has('end_work_time') ? 'is-invalid' : '' }}" type="time" name="working[0][end_time][]" id="end_work_time" value="{{ old('end_work_time', '') }}" >
                        @if($errors->has('end_work_time'))
                            <div class="invalid-feedback">
                                {{ $errors->first('end_work_time') }}
                            </div>
                        @endif

                    </div>
                    <div class="form-group col-sm-3">
                        <button class="inputAdder" type="button">
                            +
                        </button>
                    </div>
                </div> --}}



                {{-- <div class="row" x-show="show">
                    <div class="form-group col-md-4 col-sm-4 ">
                        <label for="working_day"><i class="fas fa-user-tie iconos-crear"></i>Día Laboral</label><br>
                        <select class="responsableSelect form-control" name="working[1][day][]" id="working_day">
                            <option value="">Seleccione una opción</option>
                            @foreach ($dias as $item)
                                <option  value="{{ $item }}" >{{ $item }}
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('working_day'))
                            <div class="invalid-feedback">
                                {{ $errors->first('working_day') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group col-sm-4">
                        <label class="" for="start_work_time"><i class="fas fa-user-clock iconos-crear"></i>Horario Laboral Inicio</label>
                        <input class="form-control {{ $errors->has('start_work_time') ? 'is-invalid' : '' }}" type="time" name="working[1][start_time][]" id="start_work_time" value="{{ old('start_work_time', '') }}" >
                        @if($errors->has('start_work_time'))
                            <div class="invalid-feedback">
                                {{ $errors->first('start_work_time') }}
                            </div>
                        @endif

                    </div>
                    <div class="form-group col-sm-4">
                        <label class="" for="end_work_time"><i class="fas fa-user-clock iconos-crear"></i>Horario Laboral Fin</label>
                        <input class="form-control {{ $errors->has('end_work_time') ? 'is-invalid' : '' }}" type="time" name="working[1][end_time][]" id="end_work_time" value="{{ old('end_work_time', '') }}" >
                        @if($errors->has('end_work_time'))
                            <div class="invalid-feedback">
                                {{ $errors->first('end_work_time') }}
                            </div>
                        @endif

                    </div>
                </div> --}}
                {{-- <div class="row" x-show="show">
                    <div class="form-group col-md-4 col-sm-4 ">
                        <label for="working_day"><i class="fas fa-user-tie iconos-crear"></i>Día Laboral</label><br>
                        <select class="responsableSelect form-control" name="working[2][day][]" id="working_day">
                            <option value="">Seleccione una opción</option>
                            @foreach ($dias as $item)
                                <option  value="{{ $item }}" >{{ $item }}
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('working_day'))
                            <div class="invalid-feedback">
                                {{ $errors->first('working_day') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group col-sm-4">
                        <label class="" for="start_work_time"><i class="fas fa-user-clock iconos-crear"></i>Horario Laboral Inicio</label>
                        <input class="form-control {{ $errors->has('start_work_time') ? 'is-invalid' : '' }}" type="time" name="working[2][start_time][]" id="start_work_time" value="{{ old('start_work_time', '') }}" >
                        @if($errors->has('start_work_time'))
                            <div class="invalid-feedback">
                                {{ $errors->first('start_work_time') }}
                            </div>
                        @endif

                    </div>
                    <div class="form-group col-sm-4">
                        <label class="" for="end_work_time"><i class="fas fa-user-clock iconos-crear"></i>Horario Laboral Fin</label>
                        <input class="form-control {{ $errors->has('end_work_time') ? 'is-invalid' : '' }}" type="time" name="working[2][end_time][]" id="end_work_time" value="{{ old('end_work_time', '') }}" >
                        @if($errors->has('end_work_time'))
                            <div class="invalid-feedback">
                                {{ $errors->first('end_work_time') }}
                            </div>
                        @endif

                    </div>
                </div> --}}
                {{-- <div class="row" x-show="show">
                    <div class="form-group col-md-4 col-sm-4 ">
                        <label for="working_day"><i class="fas fa-user-tie iconos-crear"></i>Día Laboral</label><br>
                        <select class="responsableSelect form-control" name="working[4][day][]" id="working_day">
                            <option value="">Seleccione una opción</option>
                            @foreach ($dias as $item)
                                <option  value="{{ $item }}" >{{ $item }}
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('working_day'))
                            <div class="invalid-feedback">
                                {{ $errors->first('working_day') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group col-sm-4">
                        <label class="" for="start_work_time"><i class="fas fa-user-clock iconos-crear"></i>Horario Laboral Inicio</label>
                        <input class="form-control {{ $errors->has('start_work_time') ? 'is-invalid' : '' }}" type="time" name="working[4][start_time][]" id="start_work_time" value="{{ old('start_work_time', '') }}" >
                        @if($errors->has('start_work_time'))
                            <div class="invalid-feedback">
                                {{ $errors->first('start_work_time') }}
                            </div>
                        @endif

                    </div>
                    <div class="form-group col-sm-4">
                        <label class="" for="end_work_time"><i class="fas fa-user-clock iconos-crear"></i>Horario Laboral Fin</label>
                        <input class="form-control {{ $errors->has('end_work_time') ? 'is-invalid' : '' }}" type="time" name="working[4][end_time][]" id="end_work_time" value="{{ old('end_work_time', '') }}" >
                        @if($errors->has('end_work_time'))
                            <div class="invalid-feedback">
                                {{ $errors->first('end_work_time') }}
                            </div>
                        @endif

                    </div>
                </div> --}}
                {{-- <div class="row" x-show="show">
                    <div class="form-group col-md-4 col-sm-4 ">
                        <label for="working_day"><i class="fas fa-user-tie iconos-crear"></i>Día Laboral</label><br>
                        <select class="responsableSelect form-control" name="working[5][day][]" id="working_day">
                            <option value="">Seleccione una opción</option>
                            @foreach ($dias as $item)
                                <option  value="{{ $item }}" >{{ $item }}
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('working_day'))
                            <div class="invalid-feedback">
                                {{ $errors->first('working_day') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group col-sm-4">
                        <label class="" for="start_work_time"><i class="fas fa-user-clock iconos-crear"></i>Horario Laboral Inicio</label>
                        <input class="form-control {{ $errors->has('start_work_time') ? 'is-invalid' : '' }}" type="time" name="working[5][start_time][]" id="start_work_time" value="{{ old('start_work_time', '') }}" >
                        @if($errors->has('start_work_time'))
                            <div class="invalid-feedback">
                                {{ $errors->first('start_work_time') }}
                            </div>
                        @endif

                    </div>
                    <div class="form-group col-sm-4">
                        <label class="" for="end_work_time"><i class="fas fa-user-clock iconos-crear"></i>Horario Laboral Fin</label>
                        <input class="form-control {{ $errors->has('end_work_time') ? 'is-invalid' : '' }}" type="time" name="working[5][end_time][]" id="end_work_time" value="{{ old('end_work_time', '') }}" >
                        @if($errors->has('end_work_time'))
                            <div class="invalid-feedback">
                                {{ $errors->first('end_work_time') }}
                            </div>
                        @endif

                    </div>
                </div> --}}
                {{-- <div class="row" x-show="show">
                    <div class="form-group col-md-4 col-sm-4 ">
                        <label for="working_day"><i class="fas fa-user-tie iconos-crear"></i>Día Laboral</label><br>
                        <select class="responsableSelect form-control" name="working[6][day][]" id="working_day">
                            <option value="">Seleccione una opción</option>
                            @foreach ($dias as $item)
                                <option  value="{{ $item }}" >{{ $item }}
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('working_day'))
                            <div class="invalid-feedback">
                                {{ $errors->first('working_day') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group col-sm-4">
                        <label class="" for="start_work_time"><i class="fas fa-user-clock iconos-crear"></i>Horario Laboral Inicio</label>
                        <input class="form-control {{ $errors->has('start_work_time') ? 'is-invalid' : '' }}" type="time" name="working[6][start_time][]" id="start_work_time" value="{{ old('start_work_time', '') }}" >
                        @if($errors->has('start_work_time'))
                            <div class="invalid-feedback">
                                {{ $errors->first('start_work_time') }}
                            </div>
                        @endif

                    </div>
                    <div class="form-group col-sm-4">
                        <label class="" for="end_work_time"><i class="fas fa-user-clock iconos-crear"></i>Horario Laboral Fin</label>
                        <input class="form-control {{ $errors->has('end_work_time') ? 'is-invalid' : '' }}" type="time" name="working[6][end_time][]" id="end_work_time" value="{{ old('end_work_time', '') }}" >
                        @if($errors->has('end_work_time'))
                            <div class="invalid-feedback">
                                {{ $errors->first('end_work_time') }}
                            </div>
                        @endif

                    </div>
                </div> --}}
                {{-- <div class="row" x-show="show">
                    <div class="form-group col-md-4 col-sm-4 ">
                        <label for="working_day"><i class="fas fa-user-tie iconos-crear"></i>Día Laboral</label><br>
                        <select class="responsableSelect form-control" name="working[7][day][]" id="working_day">
                            <option value="">Seleccione una opción</option>
                            @foreach ($dias as $item)
                                <option  value="{{ $item }}" >{{ $item }}
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('working_day'))
                            <div class="invalid-feedback">
                                {{ $errors->first('working_day') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group col-sm-4">
                        <label class="" for="start_work_time"><i class="fas fa-user-clock iconos-crear"></i>Horario Laboral Inicio</label>
                        <input class="form-control {{ $errors->has('start_work_time') ? 'is-invalid' : '' }}" type="time" name="working[7][start_time][]" id="start_work_time" value="{{ old('start_work_time', '') }}" >
                        @if($errors->has('start_work_time'))
                            <div class="invalid-feedback">
                                {{ $errors->first('start_work_time') }}
                            </div>
                        @endif

                    </div>
                    <div class="form-group col-sm-4">
                        <label class="" for="end_work_time"><i class="fas fa-user-clock iconos-crear"></i>Horario Laboral Fin</label>
                        <input class="form-control {{ $errors->has('end_work_time') ? 'is-invalid' : '' }}" type="time" name="working[7][end_time][]" id="end_work_time" value="{{ old('end_work_time', '') }}" >
                        @if($errors->has('end_work_time'))
                            <div class="invalid-feedback">
                                {{ $errors->first('end_work_time') }}
                            </div>
                        @endif

                    </div>
                </div> --}}
            {{-- </div> --}}

            <div class="form-group col-sm-6">
                <label for="logotipo"> <i class="fas fa-image iconos-crear"></i> Logotipo <strong> (Selecciona tu imagen en formato .png) </strong></label>
                <div class="mb-3 input-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" class="needsclick dropzone" name="logotipo" id="logotipo" class="form-control {{ $errors->has('logotipo') ? 'is-invalid' : '' }}"  id="logotipo-dropzone" accept="image/*" value="{{ old('logotipo', '') }}">
                        <label class="custom-file-label" for="inputGroupFile02"></label>

                    </div>
                </div>
                    @if($errors->has('logotipo'))
                    <div class="invalid-feedback">
                        {{ $errors->first('logotipo') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.organizacion.fields.logotipo_helper') }}</span>
            </div>

            <div class="col-md-12 col-sm-12">
                <div class="card vrd-agua">
                    <p class="mb-1 text-center text-white">DATOS COMPLEMENTARIOS</p>
                </div>
            </div>

            <div class="form-group col-sm-6">
                <label class="" for="representante_legal"><i class="iconos-crear fas fa-user"></i>Representante Legal</label>
                <input class="form-control {{ $errors->has('representante_legal') ? 'is-invalid' : '' }}" type="text" name="representante_legal" id="representante_legal" value="{{ old('representante_legal', '') }}" >
                @if($errors->has('representante_legal'))
                    <div class="invalid-feedback">
                        {{ $errors->first('representante_legal') }}
                    </div>
                @endif
                {{-- <span class="help-block">{{ trans('cruds.organizacion.fields.empresa_helper') }}</span> --}}
            </div>

            <div class="form-group col-sm-6">
                <label for="fecha_constitucion"><i class="iconos-crear  fas fa-calendar-alt"></i>Fecha de constitución</label>
                <input class="form-control date {{ $errors->has('fecha_constitucion') ? 'is-invalid' : '' }}" type="date" name="fecha_constitucion" id="fecha_constitucion" value="{{ old('fecha_constitucion') }}">
                @if($errors->has('fecha_constitucion'))
                <div class="invalid-feedback">
                    {{ $errors->first('fecha_constitucion') }}
                </div>
                @endif
                {{-- <span class="help-block">{{ trans('cruds.matrizRequisitoLegale.fields.fechaexpedicion_helper') }}</span> --}}
            </div>
            <div class="form-group col-sm-6">
                <label class="" for="num_empleados"><i class="iconos-crear  fas fa-users"></i>Número de empleados</label>
                <input class="form-control {{ $errors->has('num_empleados') ? 'is-invalid' : '' }}" type="number" name="num_empleados" id="num_empleados" value="{{ old('num_empleados', $countEmpleados) }}" style="" readonly >
                @if($errors->has('num_empleados'))
                    <div class="invalid-feedback">
                        {{ $errors->first('num_empleados') }}
                    </div>
                @endif
                {{-- <span class="help-block">{{ trans('cruds.organizacion.fields.empresa_helper') }}</span> --}}
            </div>
            <div class="form-group col-sm-6">
                <label class="" for="tamano"><i class="iconos-crear  fas fa-building"></i>Tamaño</label>
                <input class="form-control {{ $errors->has('tamano') ? 'is-invalid' : '' }}" type="text" name="tamano" id="tamano" value="{{ old('tamano', $tamanoEmpresa) }}" readonly>
                @if($errors->has('tamano'))
                    <div class="invalid-feedback">
                        {{ $errors->first('tamano') }}
                    </div>
                @endif
                {{-- <span class="help-block">{{ trans('cruds.organizacion.fields.empresa_helper') }}</span> --}}
            </div>





            <div class="form-group col-sm-6">
                <label for="servicios"><i class="fas fa-briefcase iconos-crear"></i> {{ trans('cruds.organizacion.fields.servicios') }}</label>
                <input class="form-control {{ $errors->has('servicios') ? 'is-invalid' : '' }}" type="text" name="servicios" id="servicios" value="{{ old('servicios', '') }}">
                @if($errors->has('servicios'))
                    <div class="invalid-feedback">
                        {{ $errors->first('servicios') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.organizacion.fields.servicios_helper') }}</span>
            </div>

            <div class="form-group col-sm-6">
                <label for="giro"> <i class="fas fa-briefcase iconos-crear"></i> {{ trans('cruds.organizacion.fields.giro') }}</label>
                <input class="form-control {{ $errors->has('giro') ? 'is-invalid' : '' }}" type="text" name="giro" id="giro" value="{{ old('giro', '') }}">
                @if($errors->has('giro'))
                    <div class="invalid-feedback">
                        {{ $errors->first('giro') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.organizacion.fields.giro_helper') }}</span>
            </div>
            <div class="form-group col-sm-6">
                <label for="mision"> <i class="fas fa-flag iconos-crear"></i> {{ trans('cruds.organizacion.fields.mision') }}</label>
                <textarea class="form-control {{ $errors->has('mision') ? 'is-invalid' : '' }}" name="mision" id="mision">{{ old('mision') }}</textarea>
                @if($errors->has('mision'))
                    <div class="invalid-feedback">
                        {{ $errors->first('mision') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.organizacion.fields.mision_helper') }}</span>
            </div>
            <div class="form-group col-sm-6">
                <label for="vision"> <i class="far fa-eye iconos-crear"></i> {{ trans('cruds.organizacion.fields.vision') }}</label>
                <textarea class="form-control {{ $errors->has('vision') ? 'is-invalid' : '' }}" name="vision" id="vision">{{ old('vision') }}</textarea>
                @if($errors->has('vision'))
                    <div class="invalid-feedback">
                        {{ $errors->first('vision') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.organizacion.fields.vision_helper') }}</span>
            </div>
            <div class="form-group col-sm-6">
                <label for="valores"> <i class="far fa-heart iconos-crear"></i> {{ trans('cruds.organizacion.fields.valores') }}</label>
                <textarea class="form-control {{ $errors->has('valores') ? 'is-invalid' : '' }}" name="valores" id="valores">{{ old('valores') }}</textarea>
                @if($errors->has('valores'))
                    <div class="invalid-feedback">
                        {{ $errors->first('valores') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.organizacion.fields.valores_helper') }}</span>
            </div>

            <div class="form-group col-sm-6">
                <label><i class="far fa-file-alt iconos-crear"></i>Antecedentes</label>
                <textarea class="form-control {{ $errors->has('antecedentes') ? 'is-invalid' : '' }}" name="antecedentes" id="antecedentes">{{ old('antecedentes') }}</textarea>
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
  $(document).ready(function () {
    var count = 1;

    dynamic_field(count);

    function dynamic_field(number) {
        html = "<tr>";
        html += '<td class="col-3"><select class="workingSelect form-control" name="working['+number+'][day][]" id="working_day"><option value="">Seleccione una opción</option>';
        html+= '<option  value="Lunes" >Lunes</option>';
        html+= '<option  value="Martes" >Martes</option>';
        html+= '<option  value="Miercoles" >Miercoles</option>';
        html+= '<option  value="Jueves" >Jueves</option>';
        html+= '<option  value="Viernes" >Viernes</option>';
        html+= '<option  value="Sabado" >Sabado</option>';
        html+= '<option  value="Domingo" >Domingo</option>';
        html+= '</select></td>';
        html +='<td class="col-3"><input class="form-control" type="time" name="working['+number+'][start_time][]" id="start_work_time" ></td>';
        html +='<td class="col-3"><input class="form-control" type="time" name="working['+number+'][end_time][]" id="end_work_time" ></td>';
        if (number > 1) {
            html +=
            '<td style="display: flex;align-items: center;justify-content: center;"><button type="button" name="remove" id="" class="btn btn-danger remove col-3" style="background-color: #d96161 !important;"><i class="fas fa-trash-alt"></i></button></td></tr>';
            $("#user_table tbody").append(html);
        } else {
            html +=
                '<td style="display: flex;align-items: center;justify-content: center;"><button type="button" name="add" id="add" class="btn btn-success col-3" ><i class="fas fa-plus-square"></i></button></td></tr>';
                $("#user_table tbody").html(html);
        }
    }




    $(document).on("click", "#add", function () {
        count++;
        var divs = document.getElementsByClassName("workingSelect").length;
        console.log("Hay " + divs + " elementos");
        if(divs <=7){
            dynamic_field(count);
        }
    });

    $(document).on("click", ".remove", function () {
      count--;
      $(this).closest("tr").remove();
    });

  });

</script>


<script>
    CKEDITOR.replace('mision', {
        toolbar: [{
        name: 'document',
            items: [
                'Maximize', '-',
                'Styles', 'Format', 'Font', 'FontSize', '-',
                'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-',
                'Bold', 'Italic', 'Underline', 'Strike', '-',
                'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-',
                'Undo', 'Redo', '-', 'Scayt', '-',
                'TextColor', 'BGColor', '-',
                'CopyFormatting', 'RemoveFormat', 'NumberedList', 'BulletedList', '-',
                'Outdent', 'Indent', '-',
                'Link', 'Unlink', 'Image', 'Table', 'SpecialChar'
            ]
        }]
    });
</script>
<script>
    CKEDITOR.replace('vision', {
        toolbar: [{
        name: 'document',
            items: [
                'Maximize', '-',
                'Styles', 'Format', 'Font', 'FontSize', '-',
                'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-',
                'Bold', 'Italic', 'Underline', 'Strike', '-',
                'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-',
                'Undo', 'Redo', '-', 'Scayt', '-',
                'TextColor', 'BGColor', '-',
                'CopyFormatting', 'RemoveFormat', 'NumberedList', 'BulletedList', '-',
                'Outdent', 'Indent', '-',
                'Link', 'Unlink', 'Image', 'Table', 'SpecialChar'
            ]
        }]
    });
</script>
<script>
    CKEDITOR.replace('valores', {
        toolbar: [{
        name: 'document',
            items: [
                'Maximize', '-',
                'Styles', 'Format', 'Font', 'FontSize', '-',
                'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-',
                'Bold', 'Italic', 'Underline', 'Strike', '-',
                'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-',
                'Undo', 'Redo', '-', 'Scayt', '-',
                'TextColor', 'BGColor', '-',
                'CopyFormatting', 'RemoveFormat', 'NumberedList', 'BulletedList', '-',
                'Outdent', 'Indent', '-',
                'Link', 'Unlink', 'Image', 'Table', 'SpecialChar'
            ]
        }]
    });
</script>
<script>
    CKEDITOR.replace('antecedentes', {
        toolbar: [{
        name: 'document',
            items: [
                'Maximize', '-',
                'Styles', 'Format', 'Font', 'FontSize', '-',
                'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-',
                'Bold', 'Italic', 'Underline', 'Strike', '-',
                'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-',
                'Undo', 'Redo', '-', 'Scayt', '-',
                'TextColor', 'BGColor', '-',
                'CopyFormatting', 'RemoveFormat', 'NumberedList', 'BulletedList', '-',
                'Outdent', 'Indent', '-',
                'Link', 'Unlink', 'Image', 'Table', 'SpecialChar'
            ]
        }]
    });
</script>

<script>

document.querySelector('.custom-file-input').addEventListener('change',function(e){
  var fileName = document.getElementById("logotipo").files[0].name;
  var nextSibling = e.target.nextElementSibling
  nextSibling.innerText = fileName
})

</script>
<script>
    Dropzone.options.logotipoDropzone = {
    url: '{{ route('admin.organizacions.storeMedia') }}',
    maxFilesize: 4, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 4,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').find('input[name="logotipo"]').remove()
      $('form').append('<input type="hidden" name="logotipo" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="logotipo"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($organizacion) && $organizacion->logotipo)
      var file = {!! json_encode($organizacion->logotipo) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="logotipo" value="' + file.file_name + '">')
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
@endsection
