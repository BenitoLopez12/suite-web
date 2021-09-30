<form method="POST" action="{{ route('admin.accion-correctivas.update', [$accionCorrectiva->id]) }}"
    enctype="multipart/form-data" class="row">
    @method('PUT')
    @csrf
    <div class="px-1 py-2 mx-3 mb-4 rounded shadow"
        style="background-color: #DBEAFE; border-top:solid 3px #3B82F6;">
        <div class="row w-100">
            <div class="text-center col-1 align-items-center d-flex justify-content-center">
                <div class="w-100">
                    <i class="fas fa-info-circle" style="color: #3B82F6; font-size: 22px"></i>
                </div>
            </div>
            <div class="col-11">
                <p class="m-0" style="font-size: 16px; font-weight: bold; color: #1E3A8A">
                    Instrucciones</p>
                <p class="m-0" style="font-size: 14px; color:#1E3A8A ">Al final de
                    cada formulario dé clic en el botón guardar antes de cambiar de pestaña,
                    de lo contrario la información capturada no será guardada.
                </p>

            </div>
        </div>
    </div>
    <div class=" form-group col-lg-2 col-md-2 col-sm-12">
        <label class="form-label"><i class="fas fa-ticket-alt iconos-crear"></i>Folio</label>
        <div class="form-control">{{ $accionCorrectiva->folio }}</div>
    </div>

    <div class="form-group col-md-6 col-lg-6 col-sm-12">
        <label for="tema"><i class="fas fa-text-width iconos-crear"></i>Título corto del incidente
        </label>
        <input class="form-control {{ $errors->has('tema') ? 'is-invalid' : '' }}" name="tema" id="tema"
            value="{{ old('tema', $accionCorrectiva->tema) }}">
        @if ($errors->has('tema'))
            <div class="invalid-feedback">
                {{ $errors->first('tema') }}
            </div>
        @endif
        <span class="help-block">{{ trans('cruds.accionCorrectiva.fields.tema_helper') }}</span>
    </div>

    <div class="form-group col-4">
        <label class="form-label"><i class="fas fa-traffic-light iconos-crear"></i>Estatus</label>
        <select name="estatus" class="form-control" id="opciones" onchange='cambioOpciones();'>
            <option {{ old('estatus', $accionCorrectiva->estatus) == 'nuevo' ? 'selected' : '' }} value="nuevo">Nuevo
            </option>
            <option {{ old('estatus', $accionCorrectiva->estatus) == 'en curso' ? 'selected' : '' }} value="en curso">
                En curso</option>
            <option {{ old('estatus', $accionCorrectiva->estatus) == 'en espera' ? 'selected' : '' }}
                value="en espera">En espera</option>
            <option {{ old('estatus', $accionCorrectiva->estatus) == 'cerrado' ? 'selected' : '' }} value="cerrado">
                Cerrado</option>
            <option {{ old('estatus', $accionCorrectiva->estatus) == 'cancelado' ? 'selected' : '' }}
                value="cancelado">Cancelado</option>
        </select>
    </div>


    <div class="form-group col-sm-12 col-md-4 col-lg-4 ">
        <label for="fecharegistro"><i class="far fa-calendar-alt iconos-crear"></i>Fecha y hora de
            registro de la AC</label>
        <input class="form-control date {{ $errors->has('fecharegistro') ? 'is-invalid' : '' }}"
            type="datetime-local" name="fecharegistro" id="fecharegistro"
            value="{{ old('fecharegistro', \Carbon\Carbon::parse($accionCorrectiva->fecharegistro)->format('Y-m-d\TH:i')) }}">
        @if ($errors->has('fecharegistro'))
            <div class="invalid-feedback">
                {{ $errors->first('fecharegistro') }}
            </div>
        @endif
    </div>


    <div class="form-group col-sm-12 col-md-4 col-lg-4">
        <label for="fecha_verificacion"> <i class="far fa-calendar-alt iconos-crear"></i> Fecha y hora de recepción de
            la AC</label>
        <input class="form-control date {{ $errors->has('fecha_verificacion') ? 'is-invalid' : '' }}"
            type="datetime-local" name="fecha_verificacion" id="fecha_verificacion"
            value="{{ old('fecha_verificacion', \Carbon\Carbon::parse($accionCorrectiva->fecha_verificacion)->format('Y-m-d\TH:i')) }}">
        @if ($errors->has('fecha_verificacion'))
            <div class="invalid-feedback">
                {{ $errors->first('fecha_verificacion') }}
            </div>
        @endif
    </div>

    <div class="form-group col-4">
        <label class="form-label"><i class="fas fa-calendar-alt iconos-crear"></i>Fecha y
            hora
            de cierre del ticket</label>
        <input class="form-control" name="fecha_cierre" value="{{ $accionCorrectiva->fecha_cierre }}" id="solucion"
            type="datetime">
    </div>


    <div class="mt-1 form-group col-12">
        <b>Reportó Acción Correctiva:</b>
    </div>

    <div class="form-group col-sm-12 col-md-4 col-lg-4">
        <label for="id_reporto"><i class="fas fa-user-tie iconos-crear"></i>Nombre</label>
        <select class="form-control {{ $errors->has('id_reporto') ? 'is-invalid' : '' }}" name="id_reporto"
            id="id_reporto">
            @foreach ($empleados as $id => $empleado)
                <option data-puesto="{{ $empleado->puesto }}" value="{{ $empleado->id }}"
                    data-area="{{ $empleado->area->area }}"
                    {{ old('id_reporto', $accionCorrectiva->id_reporto) == $empleado->id ? 'selected' : '' }}>

                    {{ $empleado->name }}
                </option>
            @endforeach
        </select>
        @if ($errors->has('id_reporto'))
            <div class="invalid-feedback">
                {{ $errors->first('id_reporto') }}
            </div>
        @endif
    </div>

    <div class="form-group col-md-4">
        <label for="id_reporto_puesto"><i class="fas fa-briefcase iconos-crear"></i>Puesto</label>
        <div class="form-control" id="reporto_puesto"></div>
    </div>


    <div class="form-group col-sm-12 col-md-4 col-lg-4">
        <label for="id_reporto_area"><i class="fas fa-street-view iconos-crear"></i>Área</label>
        <div class="form-control" id="reporto_area"></div>
    </div>


    <div class="mt-1 form-group col-12">
        <b>Registró Acción Correctiva:</b>
    </div>



    <div class="form-group col-sm-12 col-md-4 col-lg-4">
        <label for="id_registro"><i class="fas fa-user-tie iconos-crear"></i>Nombre</label>
        <select class="form-control {{ $errors->has('id_registro') ? 'is-invalid' : '' }}" name="id_registro"
            id="id_registro">
            @foreach ($empleados as $id => $empleado)
                <option data-puesto="{{ $empleado->puesto }}" value="{{ $empleado->id }}"
                    data-area="{{ $empleado->area->area }}"
                    {{ old('id_reviso', $accionCorrectiva->id_registro) == $empleado->id ? 'selected' : '' }}>

                    {{ $empleado->name }}
                </option>
            @endforeach
        </select>
        @if ($errors->has('id_registro'))
            <div class="invalid-feedback">
                {{ $errors->first('id_registro') }}
            </div>
        @endif
        <span class="help-block">{{ trans('cruds.sede.fields.organizacion_helper') }}</span>
    </div>


    <div class="form-group col-md-4">
        <label for="id_registro_puesto"><i class="fas fa-briefcase iconos-crear"></i>Puesto</label>
        <div class="form-control" id="registro_puesto"></div>
    </div>


    <div class="form-group col-sm-12 col-md-4 col-lg-4">
        <label for="id_registro_area"><i class="fas fa-street-view iconos-crear"></i>Área</label>
        <div class="form-control" id="registro_area"></div>
    </div>

    <div class="form-group col-12">
        <label><i
                class="fas fa-project-diagram iconos-crear"></i>{{ trans('cruds.accionCorrectiva.fields.causaorigen') }}
        </label>
        <select class="form-control {{ $errors->has('causaorigen') ? 'is-invalid' : '' }}" name="causaorigen"
            id="causaorigen">
            <option></option>
            <option value disabled {{ old('causaorigen', null) === null ? 'selected' : '' }}>
                {{ trans('global.pleaseSelect') }}</option>
            @foreach (App\Models\AccionCorrectiva::CAUSAORIGEN_SELECT as $key => $label)
                <option value="{{ $key }}"
                    {{ old('causaorigen', $accionCorrectiva->causaorigen) === (string) $key ? 'selected' : '' }}>
                    {{ $label }}</option>
            @endforeach
        </select>
        @if ($errors->has('causaorigen'))
            <div class="invalid-feedback">
                {{ $errors->first('causaorigen') }}
            </div>
        @endif
        <span class="help-block">{{ trans('cruds.accionCorrectiva.fields.causaorigen_helper') }}</span>
    </div>


    <div class="form-group col-12">
        <label for="descripcion"><i
                class="far fa-file-alt iconos-crear"></i>{{ trans('cruds.accionCorrectiva.fields.descripcion') }}
        </label>
        <textarea class="form-control {{ $errors->has('descripcion') ? 'is-invalid' : '' }}" name="descripcion"
            id="descripcion">{{ old('descripcion', $accionCorrectiva->descripcion) }}</textarea>
        @if ($errors->has('descripcion'))
            <div class="invalid-feedback">
                {{ $errors->first('descripcion') }}
            </div>
        @endif
        <span class="help-block">{{ trans('cruds.accionCorrectiva.fields.descripcion_helper') }}</span>
    </div>


    <div class="mt-2 form-group col-md-4 areas_multiselect">
        <label class="form-label"><i class="fas fa-puzzle-piece iconos-crear"></i>Área(s)
            afectada(s)</label>
        <select class="form-control" id="activos">
            <option disabled selected>Seleccionar áreas</option>
            @foreach ($areas as $area)
                <option value="{{ $area->area }}">{{ $area->area }}
                </option>
            @endforeach
        </select>
        <textarea name="areas" class="form-control" id="texto_activos"
            required>{{ $accionCorrectiva->areas }}</textarea>
    </div>

    <div class="mt-2 form-group col-md-4 procesos_multiselect">
        <label class="form-label"><i class="fas fa-dice-d20 iconos-crear"></i>Proceso(s)
            afectado(s)</label>
        <select class="form-control" id="activos">
            <option disabled selected>Seleccionar procesos</option>
            @foreach ($procesos as $proceso)
                <option value="{{ $proceso->nombre }}">{{ $proceso->nombre }}
                </option>
            @endforeach
        </select>
        <textarea name="procesos" class="form-control" id="texto_activos"
            required>{{ $accionCorrectiva->procesos }}</textarea>
    </div>

    <div class="mt-2 form-group col-md-4 activos_multiselect">
        <label class="form-label"><i class="fa-fw fas fa-laptop iconos-crear"></i>Activo(s)
            afectado(s)</label>
        <select class="form-control" id="activos">
            <option disabled selected>Seleccionar afectados</option>
            @foreach ($activos as $activo)
                <option value="{{ $activo->nombreactivo }}">{{ $activo->nombreactivo }}
                </option>
            @endforeach
        </select>
        <textarea name="activos" class="form-control" id="texto_activos"
            required>{{ $accionCorrectiva->activos }}</textarea>
    </div>

    <div class="mt-2 form-group col-md-12">
        <label class="form-label"><i class="fas fa-comment-dots iconos-crear"></i>Comentarios</label>
        <textarea name="comentarios" class="form-control">{{ $accionCorrectiva->comentarios }}</textarea>
    </div>

    <div class="text-right form-group col-12">
        <a href="{{ redirect()->getUrlGenerator()->previous() }}" class="btn_cancelar">Cancelar</a>
        <button class="btn btn-danger" type="submit" id="btnGuardar">
            {{ trans('global.save') }}
        </button>
        {{-- <button id="form-siguienteaccion" data-toggle="collapse" onclick="closetabcollanext2()" data-target="#collapseplan" class="btn btn-danger">Siguiente</button> --}}
    </div>

</form>
