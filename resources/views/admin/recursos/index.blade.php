@extends('layouts.admin')
@section('content')

    <style>
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

    {{ Breadcrumbs::render('admin.recursos.index') }}

    @can('recurso_create')
        <h5 class="col-12 titulo_general_funcion">Capacitaciones</h5>
        <div class="mt-5 card">
            <div style="margin-bottom: 10px; margin-left:10px;" class="row">
                <div class="col-lg-12">
                    @include('csvImport.modalcapacitaciones', ['model' => 'Vulnerabilidad', 'route' =>
                    'admin.vulnerabilidads.parseCsvImport'])
                </div>
            </div>
        @endcan


        @include('partials.flashMessages')
        <div class="card-body datatable-fix">
            <table class="table table-bordered datatable-Recurso w-100">
                <thead class="thead-dark">
                    <tr>
                        <th></th>
                        <th>
                            {{ trans('cruds.recurso.fields.id') }}
                        </th>
                        <th>
                            Nombre
                        </th>
                        <th>
                            Fecha&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </th>
                        <th>
                            {{ trans('cruds.recurso.fields.participantes') }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </th>
                        <th>
                            {{ trans('cruds.recurso.fields.instructor') }}
                        </th>
                        <th>
                            Tipo
                        </th>
                        <th>
                            Modalidad
                        </th>
                        <th>
                            Estatus
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
    <script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js"></script>
    <script>
        $(function() {
            let dtButtons = [{
                    extend: 'csvHtml5',
                    title: `Cursos y Capacitaciones ${new Date().toLocaleDateString().trim()}`,
                    text: '<i class="fas fa-file-csv" style="font-size: 1.1rem; color:#3490dc"></i>',
                    className: "btn-sm rounded pr-2",
                    titleAttr: 'Exportar CSV',
                    exportOptions: {
                        columns: ['th:not(:last-child):visible']
                    }
                },
                {
                    extend: 'excelHtml5',
                    title: `Cursos y Capacitaciones ${new Date().toLocaleDateString().trim()}`,
                    text: '<i class="fas fa-file-excel" style="font-size: 1.1rem;color:#0f6935"></i>',
                    className: "btn-sm rounded pr-2",
                    titleAttr: 'Exportar Excel',
                    exportOptions: {
                        columns: ['th:not(:last-child):visible']
                    }
                },
                {
                    extend: 'pdfHtml5',
                    title: `Cursos y Capacitaciones ${new Date().toLocaleDateString().trim()}`,
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
                    title: `Cursos y Capacitaciones ${new Date().toLocaleDateString().trim()}`,
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

            @can('recurso_create')
                let btnAgregar = {
                text: '<i class="pl-2 pr-3 fas fa-plus"></i> Agregar',
                titleAttr: 'Agregar curso y capacitación',
                url: "{{ route('admin.recursos.create') }}",
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
            @can('recurso_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
                let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.recursos.massDestroy') }}",
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

            let dtOverrideGlobals = {
                buttons: dtButtons,
                processing: true,
                serverSide: true,
                retrieve: true,
                aaSorting: [],
                ajax: "{{ route('admin.recursos.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                    }, {
                        data: 'id',
                        name: 'id',
                        visible: false
                    },
                    {
                        data: 'cursoscapacitaciones',
                        name: 'cursoscapacitaciones'
                    },
                    {
                        data: 'fecha_curso',
                        name: 'fecha_curso',
                        render: function(data, type, row, meta) {
                            return `
                                <div>
                                    <p class="m-0" style="text-align: left;">${row.fecha_inicio_format_diagonal} <strong>al</strong> ${row.fecha_fin_format_diagonal}</p>    
                                </div>
                            `;
                        }
                    },
                    {
                        data: 'id',
                        render: function(data, type, row, meta) {
                            let participantes = row.empleados;
                            let maxLength = 4;
                            let html = "";
                            let htmlRest = "";
                            if (participantes.length <= maxLength) {
                                participantes.forEach(element => {
                                    html +=
                                        `<img style="width:30px;clip-path:circle(50% at 50% 50%)" src="{{ asset('storage/empleados/imagenes/') }}/${element?.avatar}" title="${element?.name}"></img>`;
                                });
                            } else {
                                for (let index = 0; index < maxLength; index++) {
                                    const element = participantes[index];
                                    html +=
                                        `<img style="width:30px;clip-path:circle(50% at 50% 50%)" src="{{ asset('storage/empleados/imagenes/') }}/${element?.avatar}" title="${element?.name}"></img>`;
                                }
                                let empleadosRestantes = participantes.slice(maxLength, participantes
                                    .length);

                                empleadosRestantes.forEach(element => {
                                    htmlRest +=
                                        `<li class="list-group-item p-1" style="color:#fff;background-color: #000;font-size:10px; text-align:left;"><img style="width:19px;clip-path:circle(50% at 50% 50%)" src="{{ asset('storage/empleados/imagenes/') }}/${element?.avatar}"> ${element.name}</li>`;
                                });
                                html += `
                                    <span id="restantes-${data}" style="cursor: pointer;background: #289aaa;color: white;border-radius: 100%;padding: 4px;font-size: 12px;">+ ${participantes.length-maxLength}</span>
                                `
                                let template = `<div><ul class="list-group">${htmlRest}</ul></div>`;
                                tippy(`#restantes-${data}`, {
                                    content: template,
                                    allowHTML: true,
                                    theme: 'light',
                                    trigger: 'click',
                                });
                            }
                            return html
                        }
                    },
                    {
                        data: 'instructor',
                        name: 'instructor'
                    },
                    {
                        data: 'tipo',
                        name: 'tipo'
                    },
                    {
                        data: 'modalidad',
                        name: 'modalidad',
                        render: function(data, type, row, meta) {
                            return `
                            <div>
                                <p class="m-0" style="text-transform:capitalize;">${data}</p>    
                                <p class="m-0 text-muted">${row.ubicacion}</p>    
                            </div>
                            `;
                        }
                    },
                    {
                        data: 'estatus',
                        name: 'estatus'
                    },
                    {
                        data: 'id',
                        render: function(data, type, row, meta) {

                            const urlSeguimiento = `recursos/${data}`;
                            const urlEditar = `recursos/${data}/edit`
                            const urlEliminar = `recursos/${data}`
                            let html =
                                `<div class="btn-group">
                                <a href="${urlSeguimiento }" class="btn btn-sm" title="Seguimiento de la capacitación"><i class="fas fa-cogs mr-2"></i></a>`;
                            if (row.estatus == 'Borrador' || row.estatus == 'Cancelado') {
                                html += `
                                        <a href="${urlEditar}" class="btn btn-sm" title="Editar la capacitación"><i class="fas fa-edit mr-2"></i></a>
                                        `;
                            }
                            html += `<button data-url="${urlEliminar}" class="btn btn-sm btn-eliminar" title="Eliminar la capacitación"><i class="fas fa-trash mr-2 text-danger"></i>
                                </button>
                            </div>
                            `;
                            return html;
                        }
                    }
                ],
                orderCellsTop: true,
                order: [
                    [0, 'desc']
                ]
            };
            let table = $('.datatable-Recurso').DataTable(dtOverrideGlobals);
            document.querySelector('#DataTables_Table_0').addEventListener('click', function(e) {
                let target = e.target;
                if (e.target.tagName == 'I') {
                    target = e.target.closest('button')
                }

                if (target.classList.contains('btn-eliminar')) {
                    const url = e.target.getAttribute('data-url');
                    Swal.fire({
                        title: '¿Quieres eliminar esta capacitación?',
                        text: "¡No podrás revertir esto!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: '¡Sí, eliminar!',
                        cancelButtonText: 'No',
                    }).then(async (result) => {
                        if (result.isConfirmed) {
                            try {
                                const response = await fetch(url, {
                                    method: 'DELETE',
                                    body: {},
                                    headers: {
                                        Accept: "application/json",
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                                            .attr(
                                                'content'),
                                    },
                                })
                                const data = await response.json();
                                if (data.estatus == 200) {
                                    toastr.success(data.mensaje);
                                    table.ajax.reload();
                                }
                                if (data.estatus == 500) {
                                    toastr.error(data.mensaje);
                                }
                            } catch (error) {
                                toastr.error(error);
                            }
                        }
                    })
                }
            })
        });
    </script>
@endsection
