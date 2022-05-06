@extends('layouts.admin')
@section('content')

    <link rel="stylesheet" type="text/css" href="{{ asset('css/timesheet.css') }}">

    {{ Breadcrumbs::render('timesheet-dashboard') }}

    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script src="https://unpkg.com/gauge-chart@latest/dist/bundle.js"></script>
    
    <h5 class="col-12 titulo_general_funcion">TimeSheet: <font style="font-weight:lighter;">Dashboard</font> </h5>
    <div class="mt-5 card card-body">
        <nav class="mt-4">
            <div class="nav nav-tabs" id="tabsIso27001" role="tablist">
                <a class="nav-link active" id="nav-registros-tab" data-type="registros" data-toggle="tab"
                    href="#nav-registros" role="tab" aria-controls="nav-registros" aria-selected="true">
                    Organización
                </a>
                <a class="nav-link" id="nav-empleados-tab" data-type="empleados" data-toggle="tab"
                    href="#nav-empleados" role="tab" aria-controls="nav-empleados" aria-selected="false" style="position: relative;">
                    Empleados
                </a>
                <a class="nav-link" id="nav-proyectos-tab" data-type="proyectos" data-toggle="tab"
                    href="#nav-proyectos" role="tab" aria-controls="nav-proyectos" aria-selected="false">
                    proyectos
                </a>
            </div>
        </nav>

        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane mb-4 fade p-4 show active" id="nav-registros" role="tabpanel" aria-labelledby="nav-registros-tab">
                @include('admin.timesheet.dashboard.general')
            </div>
            <div class="tab-pane mb-4 fade p-4" id="nav-empleados" role="tabpanel" aria-labelledby="nav-empleados-tab">
                @include('admin.timesheet.dashboard.empleados')
            </div>
            <div class="tab-pane mb-4 fade p-4" id="nav-proyectos" role="tabpanel" aria-labelledby="nav-proyectos-tab">
                @include('admin.timesheet.dashboard.proyectos')
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    @parent
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuActive = localStorage.getItem('menu-iso27001-active');
            $(`#tabsIso27001 [data-type="${menuActive}"]`).tab('show');

            $('#tabsIso27001 a').on('click', function(event) {
                event.preventDefault()
                $(this).tab('show')
                const keyTab = this.getAttribute('data-type');
                localStorage.setItem('menu-iso27001-active', keyTab);
            });
        });
    </script>
@endsection