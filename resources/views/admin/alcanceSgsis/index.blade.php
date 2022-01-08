@extends('layouts.admin')
@section('content')

    <style>
        .table tr td:nth-child(2) {

            text-align: justify !important;

        }

        .table tr th:nth-child(3) {

            text-align: center !important;

        }

        .table tr td:nth-child(4) {

            text-align: center !important;

        }

        .table tr th:nth-child(4) {
            width: 120px !important;
            max-width: 120px !important;
            min-width: 120px !important;
            text-align: center !important;
            text-align: center !important;

        }

        .table tr th:nth-child(2) {
            width: 400px !important;
            max-width: 700px !important;
            min-width: 700px !important;
            text-align: center !important;


        }

        .table tr td:nth-child(5) {

            max-width: 200px !important;
            min-width: 200px !important;
            width: 200px !important;
            text-align: center !important;

        }

        .table tr th:nth-child(5) {

            width: 200px !important;
            max-width: 200px !important;
            min-width: 200px !important;
            text-align: center !important;

        }

        .table tr td:nth-child(6) {

            max-width: 200px !important;
            min-width: 200px !important;
            width: 200px !important;
            text-align: center !important;

        }

        .table tr th:nth-child(6) {

            width: 200px !important;
            max-width: 200px !important;
            min-width: 200px !important;
            text-align: center !important;

        }

        .table tr td:nth-child(7) {

            max-width: 200px !important;
            min-width: 200px !important;
            width: 200px !important;
            text-align: center !important;

        }

        .table tr th:nth-child(7) {

            width: 200px !important;
            max-width: 200px !important;
            min-width: 200px !important;
            text-align: center !important;

        }

        .table tr td:nth-child(8) {

            max-width: 80px !important;
            min-width: 80px !important;
            width: 80px !important;
            text-align: center !important;

        }

        .table tr th:nth-child(8) {

            width: 80px !important;
            max-width: 80px !important;
            min-width: 80px !important;
            text-align: center !important;

        }

        .btn_cargar {
            border-radius: 100px !important;
            border: 1px solid #00abb2;
            color: #00abb2;
            text-align: center;
            padding: 0;
            width: 45px;
            height: 45px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 !important;
            margin-right: 10px !important;
        }

        .btn_cargar:hover {
            color: #fff;
            background: #00abb2;
        }

        .btn_cargar i {
            font-size: 15pt;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .agregar {
            margin-right: 15px;
        }

    </style>

    {{ Breadcrumbs::render('admin.alcance-sgsis.index') }}
    @can('alcance_sgsi_create')
        <h5 class="col-12 titulo_general_funcion">Determinación de Alcance</h5>
        <div class="mt-5 card">
            {{-- <div class="py-3 col-md-10 col-sm-9 card card-body bg-primary align-self-center " style="margin-top:-40px; ">
                <h3 class="mb-2 text-center text-white"><strong>Determinación de Alcance</strong></h3>
            </div> --}}
            <div style="margin-bottom: 10px; margin-left:10px;" class="row">
                <div class="col-lg-12">
                    @include('csvImport.modalvulnerabilidad', ['model' => 'Vulnerabilidad', 'route' =>
                    'admin.vulnerabilidads.parseCsvImport'])
                </div>
            </div>
            {{-- <div style="margin-bottom: 10px; margin-left:10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.alcance-sgsis.create') }}">
                  Agregar <strong>+</strong>
            </a>
        </div>
    </div> --}}
        @endcan

        @include('partials.flashMessages')
        <div class="card-body datatable-fix">
            <table class="table table-bordered datatable-AlcanceSgsi" style="width: 100%">
                <thead class="thead-dark">
                    <tr>
                        <th>
                            {{ trans('cruds.alcanceSgsi.fields.id') }}
                        </th>
                        <th style="text-align: center !important">
                            Alcance
                        </th>
                        <th>
                            Norma&nbsp;
                        </th>
                        <th>
                            Fecha de publicación
                        </th>
                        <th>
                            Fecha&nbsp;de&nbsp;entrada en&nbsp;vigor
                        </th>
                        <th>
                            Revisó
                        </th>
                        <th>
                            Puesto
                        </th>
                        <th>
                            Área
                        </th>
                        <th>
                            Fecha&nbsp;de revisión
                        </th>
                        <th>
                            Opciones
                        </th>
                    </tr>
                    {{-- <tr>
                        <td>
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                        </td>
                    </tr> --}}
                </thead>
            </table>
        </div>
    </div>



@endsection
@section('scripts')
    @parent
    <script>
        $(function() {
            //let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            let dtButtons = [{
                    extend: 'csvHtml5',
                    title: `Alcance SGSIS ${new Date().toLocaleDateString().trim()}`,
                    text: '<i class="fas fa-file-csv" style="font-size: 1.1rem; color:#3490dc"></i>',
                    className: "btn-sm rounded pr-2",
                    titleAttr: 'Exportar CSV',
                    exportOptions: {
                        columns: ['th:not(:last-child):visible']
                    }
                },
                {
                    extend: 'excelHtml5',
                    title: `Alcance SGSIS ${new Date().toLocaleDateString().trim()}`,
                    text: '<i class="fas fa-file-excel" style="font-size: 1.1rem;color:#0f6935"></i>',
                    className: "btn-sm rounded pr-2",
                    titleAttr: 'Exportar Excel',
                    exportOptions: {
                        columns: ['th:not(:last-child):visible']
                    }
                },
                {
                    extend: 'pdfHtml5',
                    title: `Alcance SGSIS ${new Date().toLocaleDateString().trim()}`,
                    text: '<i class="fas fa-file-pdf" style="font-size: 1.1rem;color:#e3342f"></i>',
                    className: "btn-sm rounded pr-2",
                    titleAttr: 'Exportar PDF',
                    orientation: 'portrait',
                    exportOptions: {
                        columns: ['th:not(:last-child):visible']
                    },
                    customize: function(doc) {
                        // doc.pageMargins = [20, 60, 20, 30];
                        // doc.styles.tableHeader.fontSize = 7.5;
                        // doc.defaultStyle.fontSize = 7.5; //<-- set fontsize to 16 instead of 10
                    }
                },
                {
                    extend: 'print',
                    title: `Alcance SGSIS ${new Date().toLocaleDateString().trim()}`,
                    text: '<i class="fas fa-print" style="font-size: 1.1rem;"></i>',
                    className: "btn-sm rounded pr-2",
                    titleAttr: 'Imprimir',
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
            @can('alcance_sgsi_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
                let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.alcance-sgsis.massDestroy') }}",
                className: 'btn-danger',
                action: function (e, dt, node, config) {
                var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
                return entry.id
                });

                if (ids.length === 0) {
                alert('{{ trans('global.datatables.zero_selected') }}')

                return
                }

                if (confirm('{{ trans('global.areYouSure') }}')) {
                $.ajax({
                headers: {'x-csrf-token': _token},
                method: 'POST',
                url: config.url,
                data: { ids: ids, _method: 'DELETE' }})
                .done(function () { location.reload() })
                }
                }
                }
                //dtButtons.push(deleteButton)
            @endcan

            @can('alcance_sgsi_create')
                let btnAgregar = {
                text: '<i class="pl-2 pr-3 fas fa-plus"></i> Agregar',
                titleAttr: 'Agregar alcance SGSIS',
                url: "{{ route('admin.alcance-sgsis.create') }}",
                className: "btn-xs btn-outline-success rounded ml-2 pr-3 agregar",
                action: function(e, dt, node, config){
                let {url} = config;
                window.location.href = url;
                }
                };
                let btnExport = {
                text: '<i class="fas fa-download"></i>',
                titleAttr: 'Descargar plantilla',
                className: "btn btn_cargar" ,
                action: function(e, dt, node, config) {
                $('#').modal('show');
                }
                };
                let btnImport = {
                text: '<i class="fas fa-file-upload"></i>',
                titleAttr: 'Importar datos',
                className: "btn btn_cargar",
                action: function(e, dt, node, config) {
                $('#xlsxImportModal').modal('show');
                }
                };

                dtButtons.push(btnAgregar);
                dtButtons.push(btnExport);
                dtButtons.push(btnImport);
            @endcan
            let dtOverrideGlobals = {
                buttons: dtButtons,
                processing: true,
                serverSide: true,
                retrieve: true,
                aaSorting: [],
                ajax: "{{ route('admin.alcance-sgsis.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'alcancesgsi',
                        name: 'alcancesgsi'
                    },
                    {
                        data: 'norma',
                        name: 'norma'
                    },
                    {
                        data: 'fecha_publicacion',
                        name: 'fecha_publicacion'
                    },
                    {
                        data: 'fecha_entrada',
                        name: 'fecha_entrada'
                    },
                    {
                        data: 'reviso_alcance',
                        name: 'reviso_alcance'
                    },
                    {
                        data: 'puesto_reviso',
                        name: 'puesto_reviso'
                    },
                    {
                        data: 'area_reviso',
                        name: 'area_reviso'
                    },
                    {
                        data: 'fecha_revision',
                        name: 'fecha_revision'
                    },
                    {
                        data: 'actions',
                        name: '{{ trans('global.actions') }}'
                    }
                ],
                orderCellsTop: true,
                order: [
                    [0, 'desc']
                ]
            };
            let table = $('.datatable-AlcanceSgsi').DataTable(dtOverrideGlobals);
            // $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
            //     $($.fn.dataTable.tables(true)).DataTable()
            //         .columns.adjust();
            // });
            // $('.datatable thead').on('input', '.search', function() {
            //     let strict = $(this).attr('strict') || false
            //     let value = strict && this.value ? "^" + this.value + "$" : this.value
            //     table
            //         .column($(this).parent().index())
            //         .search(value, strict)
            //         .draw()
            // });
        });
    </script>
@endsection
