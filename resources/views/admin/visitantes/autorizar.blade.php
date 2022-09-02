@extends('layouts.admin')
@section('content')
    <h5 class="col-12 titulo_general_funcion">Autorizar Salidas</h5>
    <div class="mt-5 card">
        <div class="card-body">
            @livewire('visitantes.bitacora-accesos', ['tipoVista' => 'autorizar']);
        </div>
        <div class="row p-4">
            <div class="col-12" style="text-align: end">
                <a href="{{ route('admin.visitantes.menu') }}" class="btn btn-success">Regresar</a>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
@endsection
