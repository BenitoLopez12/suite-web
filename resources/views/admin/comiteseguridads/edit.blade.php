@extends('layouts.admin')
@section('content')

    {{ Breadcrumbs::render('admin.comiteseguridads.create') }}
<h5 class="col-12 titulo_general_funcion">Editar: Conformación del Comité de Seguridad</h5>
<div class="mt-4 card">
    <div class="card-body">
        <form method="POST" class="row" action="{{ route("admin.comiteseguridads.update", [$comiteseguridad->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group col-sm-12 col-md-8 col-lg-8">
                <label class="required" for="nombrerol"><i class="fas fa-user-tag iconos-crear"></i>Nombre del rol</label>
                <input class="form-control {{ $errors->has('nombrerol') ? 'is-invalid' : '' }}" type="text" name="nombrerol" id="nombrerol" value="{{ old('nombrerol', $comiteseguridad->nombrerol) }}" required>
                @if($errors->has('nombrerol'))
                    <div class="invalid-feedback">
                        {{ $errors->first('nombrerol') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.comiteseguridad.fields.nombrerol_helper') }}</span>
            </div>

            <div class="form-group col-sm-12 col-md-4 col-lg-4">
                <label for="fechavigor"><i class="far fa-calendar-alt iconos-crear"></i>Fecha de entrada en vigor</label>
                <input class="form-control {{ $errors->has('fechavigor') ? 'is-invalid' : '' }}"
                    type="date" name="fechavigor" id="fechavigor"
                    value="{{ old('fechavigor',\Carbon\Carbon::parse($comiteseguridad->fechavigor))->format('Y-m-d') }}">
                @if ($errors->has('fechavigor'))
                    <div class="invalid-feedback">
                        {{ $errors->first('fechavigor') }}
                    </div>
                @endif
            </div>



            <div class="form-group col-sm-12 col-md-4 col-lg-4">
                <label for="id_asignada"><i class="fas fa-user-tie iconos-crear"></i>Colaborador(a) asignado</label>
                <select class="form-control {{ $errors->has('id_asignada') ? 'is-invalid' : '' }}" name="id_asignada"
                    id="id_asignada">
                    <option value="">Seleccione una opción</option>
                    @foreach ($empleados as $id => $empleado)
                        <option data-puesto="{{ $empleado->puesto }}" value="{{ $empleado->id }}"
                            data-area="{{ $empleado->area->area }}"
                            {{ old('id_reviso', $comiteseguridad->id_asignada) == $empleado->id ? 'selected' : '' }}>

                            {{ $empleado->name }}
                        </option>
                    @endforeach
                </select>
                @if ($errors->has('id_asignada'))
                    <div class="invalid-feedback">
                        {{ $errors->first('id_asignada') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sede.fields.organizacion_helper') }}</span>
            </div>

            <div class="form-group col-md-4">
                <label for="id_puesto_asignada"><i class="fas fa-briefcase iconos-crear"></i>Puesto</label>
                <div class="form-control" id="puesto_asignada" readonly></div>

            </div>


            <div class="form-group col-sm-12 col-md-4 col-lg-4">
                <label for="id_area_asignada"><i class="fas fa-street-view iconos-crear"></i>Área</label>
                <div class="form-control" id="area_asignada" readonly></div>
            </div>


            <div class="form-group col-sm-12">
                <label for="responsabilidades"> <i class="fas fa-business-time iconos-crear"></i> {{ trans('cruds.comiteseguridad.fields.responsabilidades') }}</label>
                <textarea class="form-control {{ $errors->has('responsabilidades') ? 'is-invalid' : '' }}" name="responsabilidades" id="responsabilidades">{{ old('responsabilidades', $comiteseguridad->responsabilidades) }}</textarea>
                @if($errors->has('responsabilidades'))
                    <div class="invalid-feedback">
                        {{ $errors->first('responsabilidades') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.comiteseguridad.fields.responsabilidades_helper') }}</span>
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

        document.addEventListener('DOMContentLoaded', function(e) {

            let asignado = document.querySelector('#id_asignada');
            let area_init = asignado.options[asignado.selectedIndex].getAttribute('data-area');
            let puesto_init = asignado.options[asignado.selectedIndex].getAttribute('data-puesto');

            document.getElementById('puesto_asignada').innerHTML = puesto_init;
            document.getElementById('area_asignada').innerHTML = area_init;
            asignado.addEventListener('change', function(e) {
            e.preventDefault();
            let area = this.options[this.selectedIndex].getAttribute('data-area');
            let puesto = this.options[this.selectedIndex].getAttribute('data-puesto');
            document.getElementById('puesto_asignada').innerHTML = puesto;
            document.getElementById('area_asignada').innerHTML = area;
        })

        })



    </script>

@endsection
