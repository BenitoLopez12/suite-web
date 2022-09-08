@extends('layouts.admin')
@section('content')
    <style>
        .table tr th:nth-child(6) {
            min-width: 80px !important;
            text-align: center !important;
        }

        .table tr td:nth-child(6) {
            text-align: center !important;
        }

        .modal-content {

            height: 560px;
            border: none;
        }

        .modal-body {
            padding: 0;
        }
    </style>

    {{ Breadcrumbs::render('admin.auditoria-anuals.index') }}


    <h5 class="col-12 titulo_general_funcion">Programa Anual de Auditoría</h5>
    <div class="mt-5 card">
        <div class="card-body datatable-fix">
            <div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-body" id="modalContent" style="height:90%">


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        </div>

                    </div>
                </div>
            </div>

            <table class="table table-bordered w-100 datatable-AuditoriaAnual" id="programaAnual">
                <thead class="thead-dark">
                    <tr>
                        <th style="min-width: 150px;">
                            Nombre
                        </th>
                        <th>
                            Fecha&nbsp;inicio
                        </th>
                        <th>
                            Fecha&nbsp;fin
                        </th>
                        <th style="min-width: 400px;">
                            Objetivo
                        </th>
                        <th style="min-width: 400px;">
                            Alcance
                        </th>
                        <th style="min-width: 30px;">
                            Programa
                        </th>
                        <th>
                            Opciones
                        </th>
                    </tr>

                </thead>
            </table>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script>
        $(function() {
            let dtButtons = [{
                    extend: 'csvHtml5',
                    title: `Programa Anual de Auditoría ${new Date().toLocaleDateString().trim()}`,
                    text: '<i class="fas fa-file-csv" style="font-size: 1.1rem; color:#3490dc"></i>',
                    className: "btn-sm rounded pr-2",
                    titleAttr: 'Exportar CSV',
                    exportOptions: {
                        columns: ['th:not(:last-child):visible']
                    }
                },
                {
                    extend: 'excelHtml5',
                    title: `Programa Anual de Auditoría ${new Date().toLocaleDateString().trim()}`,
                    text: '<i class="fas fa-file-excel" style="font-size: 1.1rem;color:#0f6935"></i>',
                    className: "btn-sm rounded pr-2",
                    titleAttr: 'Exportar Excel',
                    exportOptions: {
                        columns: ['th:not(:last-child):visible']
                    }
                },
                {
                    extend: 'pdfHtml5',
                    title: `Programa Anual de Auditoría ${new Date().toLocaleDateString().trim()}`,
                    text: '<i class="fas fa-file-pdf" style="font-size: 1.1rem;color:#e3342f"></i>',
                    className: "btn-sm rounded pr-2",
                    titleAttr: 'Exportar PDF',
                    orientation: 'portrait',
                    exportOptions: {
                        columns: ['th:not(:last-child):visible']
                    },
                    customize: function(doc) {
                        doc.pageMargins = [20, 60, 20, 30];
                        // doc.styles.tableHeader.fontSize = 7.5;
                        // doc.defaultStyle.fontSize = 7.5; //<-- set fontsize to 16 instead of 10
                    }
                },
                {
                    extend: 'print',
                    title: `Programa Anual de Auditoría ${new Date().toLocaleDateString().trim()}`,
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

            @can('programa_anual_auditoria_agregar')
                let btnAgregar = {
                    text: '<i class="pl-2 pr-3 fas fa-plus"></i> Agregar',
                    titleAttr: 'Agregar programa anual de auditoría',
                    url: "{{ route('admin.auditoria-anuals.create') }}",
                    className: "btn-xs btn-outline-success rounded ml-2 pr-3",
                    action: function(e, dt, node, config) {
                        let {
                            url
                        } = config;
                        window.location.href = url;
                    }
                };
                dtButtons.push(btnAgregar);
            @endcan
            @can('programa_anual_auditoria_eliminar')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.auditoria-anuals.massDestroy') }}",
                    className: 'btn-danger',
                    action: function(e, dt, node, config) {
                        var ids = $.map(dt.rows({
                            selected: true
                        }).data(), function(entry) {
                            return entry.id
                        });

                        if (ids.length === 0) {
                            alert('{{ trans('global.datatables.zero_selected') }}')

                            return
                        }

                        if (confirm('{{ trans('global.areYouSure') }}')) {
                            $.ajax({
                                    headers: {
                                        'x-csrf-token': _token
                                    },
                                    method: 'POST',
                                    url: config.url,
                                    data: {
                                        ids: ids,
                                        _method: 'DELETE'
                                    }
                                })
                                .done(function() {
                                    location.reload()
                                })
                        }
                    }
                }
                //dtButtons.push(deleteButton)
            @endcan

            let dtOverrideGlobals = {
                buttons: dtButtons,
                processing: true,
                serverSide: true,
                retrieve: true,
                aaSorting: [],
                ajax: "{{ route('admin.auditoria-anuals.index') }}",
                columns: [{
                        data: 'nombre',
                        name: 'nombre'
                    },
                    {
                        data: 'fechainicio',
                        name: 'fechainicio'
                    },
                    {
                        data: 'fechafin',
                        name: 'fechafin'
                    },
                    {
                        data: 'objetivo',
                        name: 'objetivo'
                    },
                    {
                        data: 'alcance',
                        name: 'alcance'
                    },
                    {
                        data: 'enlace',
                        name: 'enlace',
                        render: function(data, type, row, meta) {
                            let id = row.id;
                            console.log(id);
                            return `
                            <div class="text-center w-100"></div>
                                <a href="auditoria-anuals/${row.id}/programa" target="_blank"><i class="fas fa-file-alt fa-2x text-info"></i></a>
                            </div
                            `;
                        }
                    },
                    {
                        data: 'actions',
                        name: '{{ trans('global.actions') }}'
                    }
                ],
                orderCellsTop: true,
                order: [
                    [0, 'desc']
                ],
            };
            let table = $('.datatable-AuditoriaAnual').DataTable(dtOverrideGlobals);
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
            document.getElementById('programaAnual').addEventListener('click', (e) => {
                if (e.target.closest('button')?.getAttribute('data-auditoria-id')) {
                    let auditoriaId = e.target.closest('button').getAttribute('data-auditoria-id');
                    let url = "{{ route('admin.auditoria-anuals.programaDocumentos') }}";
                    $.ajax({
                        type: "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: url,
                        data: {
                            auditoriaId
                        },
                        dataType: "Json",
                        success: function(response) {
                            let html = "";
                            if (response.paths.length == 0) {
                                html = `
                                <span>Sin registro</span>
                                `
                            } else {
                                response.paths.forEach(element => {
                                    let {
                                        path,
                                        extension
                                    } = element;
                                    if (extension == 'pdf') {
                                        html += `
                                <iframe width="100%" height="100%"  src="${path}"></iframe>
                                `
                                    } else {
                                        html += `
                                <img src="${path}"></img>
                                `
                                    }
                                });
                            }


                            document.getElementById('modalContent').innerHTML = html;

                        }
                    });
                }
            })
        });
    </script>
@endsection
