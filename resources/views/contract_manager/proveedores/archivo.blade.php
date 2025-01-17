@extends('layouts.admin')
@section('content')
    <style>
        .table tr td:nth-child(1) {
            min-width: 200px !important;
        }

        .table tr td:nth-child(4) {
            min-width: 200px !important;
        }
    </style>

    @include('partials.flashMessages')
    <h5 class="col-12 titulo_general_funcion">Proveedores</h5>
    <div class="mt-5 card">

        <div class="card-body datatable-fix">

            <table class="table table-bordered w-100 datatable-Proveedores">
                <thead class="thead-dark">
                    <tr>
                        <th style="vertical-align: top">
                            Nombre
                        </th>
                        <th style="vertical-align: top">
                            Razon Social
                        </th>
                        <th style="vertical-align: top">
                            RFC
                        </th>
                        <th style="vertical-align: top">
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
                    title: `Proveedores ${new Date().toLocaleDateString().trim()}`,
                    text: '<i class="fas fa-file-csv" style="font-size: 1.1rem; color:#3490dc"></i>',
                    className: "btn-sm rounded pr-2",
                    titleAttr: 'Exportar CSV',
                    exportOptions: {
                        columns: ['th:not(:last-child):visible']
                    }
                },
                {
                    extend: 'excelHtml5',
                    title: `Proveedores ${new Date().toLocaleDateString().trim()}`,
                    text: '<i class="fas fa-file-excel" style="font-size: 1.1rem;color:#0f6935"></i>',
                    className: "btn-sm rounded pr-2",
                    titleAttr: 'Exportar Excel',
                    exportOptions: {
                        columns: ['th:not(:last-child):visible']
                    }
                },
                {
                    extend: 'pdfHtml5',
                    title: `Proveedores ${new Date().toLocaleDateString().trim()}`,
                    text: '<i class="fas fa-file-pdf" style="font-size: 1.1rem;color:#e3342f"></i>',
                    className: "btn-sm rounded pr-2",
                    titleAttr: 'Exportar PDF',
                    orientation: 'landscape',
                    exportOptions: {
                        columns: ['th:not(:last-child):visible']
                    },
                    customize: function(doc) {
                        doc.pageMargins = [5, 20, 5, 20];
                        // doc.styles.tableHeader.fontSize = 6.5;
                        // doc.defaultStyle.fontSize = 6.5; //<-- set fontsize to 16 instead of 10
                    }
                },
                {
                    extend: 'print',
                    title: `Proveedores ${new Date().toLocaleDateString().trim()}`,
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
            let btnAgregar = {
                text: '<i class="fa-solid fa-backward"></i> Proveedores',
                titleAttr: 'Proveedores usuario',
                url: "{{ route('contract_manager.proveedores.index') }}",
                className: "btn-xs btn-outline-success rounded ml-2 pr-3",
                action: function(e, dt, node, config) {
                    let {
                        url
                    } = config;
                    window.location.href = url;
                }
            };
            dtButtons.push(btnAgregar);
            let archivarButton = {
                text: 'Archivar Registro',
                url: "{{ route('contract_manager.proveedores.archivar', ['id' => 1]) }}",
                className: 'btn-danger',
                action: function(e, dt, node, config) {
                    var ids = $.map(dt.rows({
                        selected: true
                    }).data(), function(entry) {
                        return entry.id
                    });

                    if (ids.length === 0) {
                        alert('undefine')

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
                                    _method: 'POST'
                                }
                            })
                            .done(function() {
                                location.reload()
                            })
                    }
                }
            }

            let dtOverrideGlobals = {
                buttons: dtButtons,
                processing: true,
                serverSide: true,
                retrieve: true,
                aaSorting: [],
                ajax: {
                    url: "{{ route('contract_manager.proveedores.getArchivadosIndex') }}",
                    type: 'POST',
                    data: {
                        _token: _token
                    }
                },
                columns: [{
                        data: 'nombre',
                        name: 'nombre'
                    },
                    {
                        data: 'razon_social',
                        name: 'razon_social'
                    },
                    {
                        data: 'rfc',
                        name: 'rfc'
                    },
                    {
                        data: 'id',
                        name: 'actions',
                        render: function(data, type, row, meta) {
                            let proveedores = @json($proveedores);
                            let urlButtonArchivar = `/contract_manager/proveedores/archivar/${data}`;
                            let urlButtonEdit = `/contract_manager/proveedores/${data}/edit`;
                            let htmlBotones =
                                `
                                <div class="btn-group">
                                    <a href="${urlButtonEdit}" class="btn btn-sm" title="Editar"><i class="fas fa-edit"></i></a>
                                    <a title="Archivar" class="btn btn-sm text-blue"  onclick="Archivar('${urlButtonArchivar}','${row.nombre}');"> <i class="fa-solid fa-box-archive"></i></a>
                                </div>

                            `;
                            return htmlBotones;
                        }
                    }
                ],
                orderCellsTop: true,
                order: [
                    [0, 'desc']
                ]
            };
            let table = $('.datatable-Proveedores').DataTable(dtOverrideGlobals);

            window.Archivar = function(url, nombre) {
                Swal.fire({
                    title: `¿Estás seguro de desarchivar el siguiente registro?`,
                    html: `<strong><i class="mr-2 fas fa-exclamation-triangle"></i>${nombre}</strong>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '¡Sí, desarchivar!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            headers: {
                                'x-csrf-token': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: url,
                            beforeSend: function() {
                                Swal.fire(
                                    '¡Estamos Desarchivando!',
                                    `El proveedor: ${nombre} está siendo desarchivado`,
                                    'info'
                                )
                            },
                            success: function(response) {
                                Swal.fire(
                                    'Desarchivado!',
                                    `El proveedor: ${nombre} ha sido desarchivado`,
                                    'success'
                                ).then(() => {
                                    window.location.href = '/contract_manager/proveedores'; // Replace '/index' with your actual index page URL
                                });

                                table.ajax.reload();
                            },
                            error: function(error) {
                                console.log(error);
                                Swal.fire(
                                    'Ocurrió un error',
                                    `Error: ${error.responseJSON.message}`,
                                    'error'
                                )
                            }
                        });
                    }
                })
            }

        });
    </script>
@endsection
