@extends('layouts.admin')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/timesheet.css') }}{{ config('app.cssVersion') }}">
@endsection
@section('styles')
    <style>
        .select2-dropdown {
            transform: translate(0) !important;
        }

        .text-wrap {
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .btn.dropdown-toggle::after {
            position: absolute;
            right: 0.75rem;
            /* Adjust as needed to position the arrow */
            top: 50%;
            transform: translateY(-50%);
            margin-left: -0.255em;
            vertical-align: 0.255em;
            content: "";
            border-top: 0.3em solid;
            border-right: 0.3em solid transparent;
            border-bottom: 0;
            border-left: 0.3em solid transparent;
            pointer-events: none;
        }
    </style>
@endsection
@section('content')
    <h5 class="col-12 titulo_general_funcion">
        TimeSheet:
        <font style="font-weight:lighter;">
            Asignacion de Empleados por Proyecto
        </font>
    </h5>
    <div class="card card-body">
        <div class="row">
            @livewire('timesheet.timesheet-proyecto-empleados-component', ['proyecto_id' => $proyecto->id])
        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script>
        let cont = 0;

        function tablaLivewire(id_tabla) {
            $('#' + id_tabla).attr('id', id_tabla + cont);
            $(function() {
                let dtButtons = [{
                        extend: 'csvHtml5',
                        title: `Mis Registros ${new Date().toLocaleDateString().trim()}`,
                        text: '<i class="fas fa-file-csv" style="font-size: 1.1rem; color:#3490dc"></i>',
                        className: "btn-sm rounded pr-2",
                        titleAttr: 'Exportar CSV',
                        exportOptions: {
                            columns: ['th:not(:last-child):visible']
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        title: `Mis Registros ${new Date().toLocaleDateString().trim()}`,
                        text: '<i class="fas fa-file-excel" style="font-size: 1.1rem;color:#0f6935"></i>',
                        className: "btn-sm rounded pr-2",
                        titleAttr: 'Exportar Excel',
                        exportOptions: {
                            columns: ['th:not(:last-child):visible']
                        }
                    },
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print" style="font-size: 1.1rem;color:#345183"></i>',
                        className: "btn-sm rounded pr-2",
                        titleAttr: 'Imprimir',
                        customize: function(doc) {
                            let logo_actual = @json($logo_actual);
                            let empresa_actual = @json($empresa_actual);
                            let empleado = @json(auth()->user()->empleado->name);
                            var now = new Date();
                            var jsDate = now.getDate() + '-' + (now.getMonth() + 1) + '-' + now
                                .getFullYear();
                            $(doc.document.body).prepend(`
                                <div class="row">
                                    <div class="col-4 text-center p-2" style="border:2px solid #CCCCCC">
                                        <img class="img-fluid" style="max-width:120px" src="${logo_actual}"/>
                                    </div>
                                    <div class="col-4 text-center p-2" style="border:2px solid #CCCCCC">
                                        <p>${empresa_actual}</p>
                                        <strong style="color:#345183">Timesheet: Empleados en Proyecto</strong>
                                    </div>
                                    <div class="col-4 text-center p-2" style="border:2px solid #CCCCCC">
                                        Fecha: ${jsDate}
                                    </div>
                                </div>
                            `);
                            $(doc.document.body).find('table')
                                .css('font-size', '12px')
                                .css('margin-top', '15px')
                            $(doc.document.body).find('th').each(function(index) {
                                $(this).css('font-size', '18px');
                                $(this).css('color', '#fff');
                                $(this).css('background-color', 'blue');
                            });
                        },
                        title: '',
                        exportOptions: {
                            columns: ['th:not(:last-child):visible']
                        }
                    },
                    {
                        extend: 'colvis',
                        text: '<i class="fas fa-filter" style="font-size: 1.1rem;"></i>',
                        className: "btn-sm rounded pr-2",
                        titleAttr: 'Seleccionar Columnas',
                    },
                    {
                        extend: 'colvisGroup',
                        text: '<i class="fas fa-eye" style="font-size: 1.1rem;"></i>',
                        className: "btn-sm rounded pr-2",
                        show: ':hidden',
                        titleAttr: 'Ver todo',
                    },
                    {
                        extend: 'colvisRestore',
                        text: '<i class="fas fa-undo" style="font-size: 1.1rem;"></i>',
                        className: "btn-sm rounded pr-2",
                        titleAttr: 'Restaurar a estado anterior',
                    }
                ];
                let dtOverrideGlobals = {
                    buttons: dtButtons,
                    destroy: true,
                    render: true,
                    paging: true, // Enable pagination
                    pageLength: 10, // Set the number of records per page
                    lengthMenu: [5, 10, 25, 50, 100], // Define available page lengths
                };
                let table = $('#' + id_tabla + cont).DataTable(dtOverrideGlobals);
            });
        }
        document.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                tablaLivewire('tabla_time_poyect_empleados');
            }, 100);
        });
    </script>
@endsection
