@extends('layouts.admin')
@section('content')
    <style>
        .img-profile {
            width: 95px;
            height: 95px;
            clip-path: circle(40px at 50% 50%);
        }

        .img-profile-lg {
            width: 95px;
            height: 95px;
            clip-path: circle(100px at 50% 50%);
        }

        hr.hr-custom-title {
            width: 100%;
            margin: 8px 0;
            border: 1px solid #345183
        }

    </style>
    <div class="mt-3">
        {{ Breadcrumbs::render('EV360-Objetivos-Show', ['empleado' => $empleado]) }}
    </div>
    <div class="mt-5 card">
        <div class="py-3 col-md-10 col-sm-9 card card-body bg-primary align-self-center " style="margin-top:-40px; ">
            <h3 class="mb-2 text-center text-white"><strong>Objetivos Estratégicos</strong></h3>
        </div>
        @include('partials.flashMessages')
        <div class="card-body">
            <div class="col-12">
                <div class="mb-2">
                    <div class="row justify-content-center align-self-center">
                        <div class="text-center col-2" style="align-self: end;">
                            <div>
                                <img class="img-fluid img-profile" style="position: relative;"
                                    src="{{ asset('storage/empleados/imagenes') }}/{{ $empleado ? $empleado->avatar : 'user.png' }}">
                            </div>
                        </div>
                        <div class="col-8" style="align-self: end;">
                            <div>
                                <h4>{{ $empleado->name }}</h4>
                                <p class="mb-1 text-secondary">{{ $empleado->puesto }}</p>
                                <p class="m-0 text-muted font-size-sm">{{ $empleado->area->area }}</p>
                                {{-- <button class="btn btn-primary">Follow</button>
                                        <button class="btn btn-outline-primary">Message</button> --}}
                            </div>
                        </div>
                        <div class="text-center col-2">
                            @php
                                use App\Models\Organizacion;
                                $organizacion = Organizacion::first();
                                 $logotipo = 'img/logo_policromatico_2.png';
                                if ($organizacion) {
                                    if ($organizacion->logotipo) {
                                        $logotipo = '' . $organizacion->logotipo;
                                    }
                                }
                            @endphp

                            <img class="img-profile-lg" style="position: relative;" src="{{ ($logotipo) }}">
                        </div>
                    </div>
                </div>
                <hr class="hr-custom-title">
                <br>
            </div>
            <div class="col-12 datatable-fix">
                <table class="table table-bordered w-100 tblObjetivos">
                    <thead class="thead-dark">
                        <tr>
                            <th style="vertical-align: top">
                                Perspectiva
                            </th>
                            <th style="vertical-align: top">
                                Objetivos Estratégicos
                            </th>
                            <th style="vertical-align: top">
                                KPI
                            </th>
                            <th style="vertical-align: top">
                                Meta
                            </th>
                            {{-- <th style="vertical-align: top">
                                Unidad
                            </th> --}}
                            <th style="vertical-align: top">
                                Descripción
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="col-12" style="text-align: end">
                <div class="mt-2">
                    <a href="{{ url()->previous() }}" class="btn btn_cancelar">Regresar</a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script>
        $(function() {
            let dtButtons = [];

            let dtOverrideGlobals = {
                buttons: dtButtons,
                processing: true,
                serverSide: true,
                retrieve: true,
                ajax: "{{ route('admin.ev360-objetivos-empleado.create', $empleado->id) }}",
                columns: [{
                    data: 'objetivo.tipo.nombre',
                }, {
                    data: 'objetivo.nombre'
                }, {
                    data: 'objetivo.KPI',
                }, {
                    data: 'objetivo',
                    render: function(data, type, row, meta) {
                        return data.meta + ' ' + data.metrica.definicion;
                    }
                }, {
                    data: 'objetivo.descripcion_meta',
                }],
                order: [
                    [1, 'asc']
                ],
                dom: "<'row align-items-center justify-content-center container m-0 p-0'<'col-12 col-sm-12 col-md-3 col-lg-3 m-0'l><'text-center col-12 col-sm-12 col-md-6 col-lg-6'B><'col-md-3 col-12 col-sm-12 m-0 p-0'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row align-items-center justify-content-end'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6 d-flex justify-content-end'p>>",
            };
            window.tblObjetivos = $('.tblObjetivos').DataTable(dtOverrideGlobals);
        });
    </script>
@endsection
