@extends('layouts.admin')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/timesheet.css') }}{{ config('app.cssVersion') }}">
@endsection
@section('content')

    <h5 class="col-12 titulo_general_funcion">Timesheet: <font style="font-weight:lighter;">Proyecto</font>
    </h5>

    {{-- @include('admin.timesheet.complementos.cards') --}}
    @include('admin.timesheet.complementos.admin-aprob')
    {{-- @include('admin.timesheet.complementos.blue-card-header') --}}

    <div class="card card-body mt-4">
        @php
            use App\Models\TimesheetHoras;
        @endphp
        @can('timesheet_administrador_proyectos_create')
            <div class="row">
                <div class="col-12">
                    <h4 class="title-card-time">Nuevo Proyecto</h4>
                    <hr class="my-4">
                </div>
            </div>
            <form method="POST" action="{{ route('admin.timesheet-proyectos-store') }}">
                @csrf
                <div class="row">
                    <div class="form-group col-md-2 anima-focus">
                        <input type="text" id="identificador_proyect" placeholder=""
                            title="Por favor, no incluyas comas en el nombre de la tarea." name="identificador"
                            pattern="[^\.,]*" class="form-control" maxlength="254" required>
                        {!! Form::label('identificador', 'ID*', ['class' => 'asterisco']) !!}
                        @if ($errors->has('identificador'))
                            <div class="invalid-feedback">
                                {{ $errors->first('identificador') }}
                            </div>
                        @endif
                        @error('identificador')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group col-md-6 anima-focus">
                        <input type="text" id="name_proyect" placeholder="" name="proyecto_name" class="form-control"
                            maxlength="254" required>
                        {!! Form::label('name_proyect', 'Nombre del proyecto*', ['class' => 'asterisco']) !!}
                        <span id="alertaGenerica" style="color: red; display: none;"></span>
                    </div>
                    <div class="form-group col-md-4 anima-focus">
                        <select name="cliente_id" id="cliente_id" class="form-control" required>
                            <option selected value="">Seleccione cliente</option>
                            @foreach ($clientes as $cliente)
                                <option value="{{ $cliente->id }}">{{ $cliente->nombre }}
                                </option>
                            @endforeach
                        </select>
                        {!! Form::label('cliente_id', 'Cliente*', ['class' => 'asterisco']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4 anima-focus" style="position: relative; top: -1.5rem;"
                        id="caja_areas_seleccionadas_create">
                        <select class="select2-multiple form-control" multiple="multiple" id="areas_seleccionadas"
                            name="areas_seleccionadas[]" required>
                            @foreach ($areas as $area)
                                <option value="{{ $area->id }}">
                                    {{ $area->area }}
                                </option>
                            @endforeach
                        </select>
                        {!! Form::label('areas_seleccionadas', ' Área(s) participante(s)*', ['class' => 'asterisco']) !!}
                        <div class="mt-1">
                            <input id="chkall" name="chkall" type="checkbox" value="todos"> Seleccionar Todas
                        </div>
                    </div>
                    <div class="form-group col-md-4 anima-focus">
                        <input type="date" name="fecha_inicio" placeholder="" id="fecha_inicio" class="form-control">
                        {!! Form::label('fecha_inicio', 'Fecha de inicio', ['class' => 'asterisco']) !!}
                        @if ($errors->has('fecha_inicio'))
                            <div class="invalid-feedback">
                                {{ $errors->first('fecha_inicio') }}
                            </div>
                        @endif
                        @error('fecha_inicio')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group col-md-4 anima-focus">
                        <input type="date" name="fecha_fin" id="fecha_fin" class="form-control">
                        {!! Form::label('fecha_fin', 'Fecha de fin', ['class' => 'asterisco']) !!}
                        @if ($errors->has('fecha_fin'))
                            <div class="invalid-feedback">
                                {{ $errors->first('fecha_fin') }}
                            </div>
                        @endif
                        @error('fecha_fin')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4 anima-focus">
                        <select class="form-control" name="sede_id" id="sede_id" required>
                            <option selected value="">Seleccione sede</option>
                            @foreach ($sedes as $sede)
                                <option value="{{ $sede->id }}">{{ $sede->sede }}</option>
                            @endforeach
                        </select>
                        {!! Form::label('sede_id', 'Sede', ['class' => 'asterisco']) !!}
                    </div>
                    <div class="form-group col-md-4 anima-focus">
                        <select class="form-control" name="tipo" id="tipo" required>
                            @foreach ($tipos as $tipo_it)
                                <option value="{{ $tipo_it }}" {{ $tipo == $tipo_it ? 'selected' : '' }}>
                                    {{ $tipo_it }}
                                </option>
                            @endforeach
                        </select>
                        {!! Form::label('tipo', 'Tipo', ['class' => 'asterisco']) !!}
                    </div>
                    <div class="form-group col-md-4 anima-focus">
                        <input type="text" pattern="[0-9]+" title="Por favor, ingrese solo números enteros." placeholder=""
                            name="horas_proyecto" maxlength="250" id="horas_asignadas" class="form-control">
                        {!! Form::label('horas_proyecto', 'Horas Asignadas al proyecto', ['class' => 'asterisco']) !!}
                        @if ($errors->has('horas_proyecto'))
                            <div class="invalid-feedback">
                                {{ $errors->first('horas_proyecto') }}
                            </div>
                        @endif
                    </div>
                </div>
                {{-- <div class="row">
                  <div class="form-group col-md-4">
                    <label class="form-label"><i class="fa-solid fa-calendar-day iconos-crear"></i>Proveedor (Opcional)</label>
                    <input type="text" name="proveedor" id="proveedor" class="form-control">
                    @if ($errors->has('proveedor'))
                        <div class="invalid-feedback">
                            {{ $errors->first('proveedor') }}
                        </div>
                    @endif
                </div>
                <div class="form-group col-md-4">
                    <label class="form-label"><i class="fa-solid fa-calendar-day iconos-crear"></i> Horas Asignadas del Tercero (Opcional)</label>
                    <input type="number" min="0" name="horas_tercero" id="horas_asignadas" class="form-control">
                    @if ($errors->has('horas_tercero'))
                        <div class="invalid-feedback">
                            {{ $errors->first('horas_tercero') }}
                        </div>
                    @endif
                </div>
            </div>  --}}
                <div class="row">
                    <div class="form-group col-12 text-right">
                        <button class="btn btn-success" type="submit"> Crear Proyecto</button>
                    </div>
                </div>
            </form>
        @endcan
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Select2 Multiple
            $('.select2-multiple').select2({
                theme: 'bootstrap4',
                allowClear: true
            });

        });
    </script>
@endsection
