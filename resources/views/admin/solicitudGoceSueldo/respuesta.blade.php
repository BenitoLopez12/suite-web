@extends('layouts.admin')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{!! route('admin.solicitud-permiso-goce-sueldo.aprobacion') !!}">Aprobar Permiso con Goce de Sueldo</a>
        </li>
        <li class="breadcrumb-item active">Ver</li>
    </ol>
    <h5 class="col-12 titulo_general_funcion">Aprobar: Solicitud de permiso con Goce de Sueldo</h5>
    <div class="mt-4 card">
        <div class="card-body">
            {!! Form::model($vacacion, [
                'route' => ['admin.solicitud-permiso-goce-sueldo.update', $vacacion->id],
                'method' => 'patch',
            ]) !!}

            <div class="row">
                <!-- Categoria Enabled-->
                <div class="col-12 col-sm-12">
                    <div class="text-center form-group"
                        style="background-color:#345183; border-radius: 100px; color: white;">
                        DETALLES DE LA SOLICITUD
                    </div>
                    <!-- Categoria Field -->
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <fieldset disabled>
                                <label for="disabledTextInput"><i
                                        class="fa-solid fa-calendar-check iconos-crear"></i>Colaborador</label>
                                <input type="text" class="form-control" value="{{ $vacacion->empleado->name }}"
                                    style="text-align: center">
                            </fieldset>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <fieldset disabled>
                                <label for="disabledTextInput"><i
                                        class="fa-solid fa-calendar-check iconos-crear"></i>Puesto</label>
                                <input type="text" class="form-control" value="{{ $vacacion->empleado->puesto }}"
                                    style="text-align: center">
                            </fieldset>
                        </div>
                        <div class="form-group col-sm-6">
                            <fieldset disabled>
                                <label for="disabledTextInput"><i
                                        class="fa-solid fa-calendar-check iconos-crear"></i>Area</label>
                                <input type="text" class="form-control" value="{{ $vacacion->empleado->area->area }}"
                                    style="text-align: center">
                            </fieldset>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <fieldset disabled>
                                <label for="disabledTextInput"><i class="fa-solid fa-calendar-check iconos-crear"></i>Tipos
                                    de Permiso</label>
                                <input type="text" id="disabledTextInput" class="form-control"
                                    value="{{ $vacacion->permiso->nombre }}" style="text-align: center">
                            </fieldset>
                        </div>

                    </div>
                    <!-- Categoria Field -->
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="disabledTextInput"> <i class="fa-solid fa-calendar-day iconos-crear"></i>Numero
                                de
                                días otorgados por la organización:</label>
                            <input type="text" class="form-control" value="{{ $vacacion->dias_solicitados }}"
                                style="text-align: center" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="disabledTextInput"><i class="fa-solid fa-file-circle-check iconos-crear"></i>Fecha
                                de inicio propuesta:</label>
                            <input type="text" class="form-control"
                                value="{{ \Carbon\Carbon::parse($vacacion->fecha_inicio)->format('d/m/Y') }}"
                                style="text-align: center" readonly>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="disabledTextInput"> <i class="fa-solid fa-file-circle-xmark iconos-crear"></i>Fecha
                                fin  propuesta:</label>
                            <input type="text" class="form-control"
                                value="{{ \Carbon\Carbon::parse($vacacion->fecha_fin)->format('d/m/Y') }}"
                                style="text-align: center" readonly>
                        </div>
                    </div>
                    <!-- Categoria Field -->

                   

                    <!-- Descripcion Field -->
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="exampleFormControlTextarea1"> <i
                                    class="fas fa-file-alt iconos-crear"></i>{!! Form::label('descripcion', 'Comentarios:') !!}</label>
                            <textarea class="form-control" id="edescripcion" name="descripcion" rows="2" disabled>{{ old('descripcion', $vacacion->descripcion) }}</textarea>
                        </div>
                    </div>

                    <div class="text-center form-group"
                        style="background-color:#345183; border-radius: 100px; color: white;">
                        RESPUESTA
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="aprobacion" class="">Aprueba:</label>
                            <select class="form-control" name="aprobacion">
                                <option selected disabled>Seleccione...</option>
                                <option value="3">Sí</option>
                                <option value="2">No</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="exampleFormControlTextarea1"> <i
                                    class="fas fa-file-alt iconos-crear"></i>{!! Form::label('comentarios_aprobador', 'Comentarios:') !!}</label>
                            <textarea class="form-control" name="comentarios_aprobador" rows="2">{{ old('descripcion', $vacacion->comentarios_aprobador) }}</textarea>
                        </div>
                    </div>
                    <input type="hidden"
                        value="{{  $vacacion->empleado_id}}"
                        name="empleado_id">
                    <input type="hidden" value="{{ $vacacion->autoriza}}" name="autoriza">
                    <!-- Submit Field -->
                    <div class="text-right form-group col-12">
                        <a href="{{ redirect()->getUrlGenerator()->previous() }}" class="btn_cancelar">Cancelar</a>
                        <button class="btn btn-danger" type="submit">
                            {{ trans('global.save') }}
                        </button>
                    </div>
                </div>
            </div>



            {!! Form::close() !!}
        </div>
    </div>
@endsection
