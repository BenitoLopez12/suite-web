@extends('layouts.admin')
@section('content')

    {{ Breadcrumbs::render('admin.comiteseguridads.create') }}
<h5 class="col-12 titulo_general_funcion">Editar: Conformación del Comité</h5>

<div class="mt-4 card">
    <div class="card-body">
        <form method="POST" class="row" action="{{ route("admin.comiteseguridads.update", [$comiteseguridad->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group col-sm-12 col-md-12 col-lg-12">
                <label class="required" for="nombre_comite"><i class="fas fa-gavel iconos-crear"></i></i>Nombre del
                    Comité</label>
                <input class="form-control {{ $errors->has('nombre_comite') ? 'is-invalid' : '' }}" type="text"
                    name="nombre_comite" id="nombre_comite" value="{{ old('nombre_comite', $comiteseguridad->nombre_comite) }}" required>
                @if ($errors->has('nombre_comite'))
                    <div class="invalid-feedback">
                        {{ $errors->first('nombre_comite') }}
                    </div>
                @endif

            </div>

            <div class="form-group col-sm-12 col-md-12 col-lg-12">
                <label for="descripcion"><i class="fas fa-align-justify iconos-crear"></i>Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="4">{{ old('descripcion',  $comiteseguridad->descripcion) }}</textarea>
                @if ($errors->has('nombre_comite'))
                    <div class="invalid-feedback">
                        {{ $errors->first('nombre_comite') }}
                    </div>
                @endif

            </div>

            @livewire('show-miembros-comite-seguridad',['id_comite'=>$comiteseguridad->id])

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
