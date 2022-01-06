@extends('layouts.admin')
@section('content')

<style>

    .table tr th:nth-child(3){
    min-width:600px !important;
    text-align:center !important;
    }

    .table tr td:nth-child(3){
    text-align:justify !important;
    }

    .table tr th:nth-child(4){
    min-width:100px !important;
    text-align:center !important;
    }

    .table tr td:nth-child(4){
    text-align:center !important;
    }

    .table tr th:nth-child(5){
    min-width:80px !important;
    text-align:center !important;
    }

    .table tr td:nth-child(5){concien
    text-align:center !important;
    }

    .table tr th:nth-child(6){
    min-width:130px !important;
    text-align:center !important;
    }

    .table tr td:nth-child(6){
    text-align:center !important;
    }
    .carousel-control-next, .carousel-control-prev {
        width: 50px;
        height: 50px;
        margin-top: 100px;
    }

    .img-size{
        margin-left:calc(50% - 141px);
    }

    .carousel-control-prev-icon, .carousel-control-next-icon{
        background-color: #000;
        filter: invert(100%);
    }


</style>


    {{ Breadcrumbs::render('admin.evidencias-sgsis.index') }}

    <h5 class="col-12 titulo_general_funcion">Evidencia de Asignación de Recursos al SGSI</h5>

    @can('evidencias_sgsi_create')
        <div class="mt-5 card">

    @endcan

        @include('partials.flashMessages')
        <div class="card-body datatable-fix">
            <table class="table table-bordered datatable-EvidenciasSgsi" style="width: 100%">
                <thead class="thead-dark">
                    <tr>
                        <th>
                            {{ trans('cruds.evidenciasSgsi.fields.id') }}
                        </th>
                        <th>
                            Nombre&nbsp;del&nbsp;documento
                        </th>
                        <th>
                            {{ trans('cruds.evidenciasSgsi.fields.objetivodocumento') }}
                        </th>
                        <th>
                            {{ trans('cruds.evidenciasSgsi.fields.responsable') }}
                        </th>
                        <th>
                            {{ trans('cruds.evidenciasSgsi.fields.arearesponsable') }}
                        </th>
                        <th>
                            {{ trans('cruds.evidenciasSgsi.fields.fechadocumento') }}
                        </th>
                        <th>
                            {{ trans('cruds.evidenciasSgsi.fields.archivopdf') }}
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
                            <select class="search">
                                <option value>{{ trans('global.all') }}</option>
                                @foreach ($users as $key => $item)
                                    <option value="{{ $item->name }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                        </td>
                        <td>
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
            let dtButtons = [{
                    extend: 'csvHtml5',
                    title: `Evidencia de Asignación de Recursos al SGSI ${new Date().toLocaleDateString().trim()}`,
                    text: '<i class="fas fa-file-csv" style="font-size: 1.1rem; color:#3490dc"></i>',
                    className: "btn-sm rounded pr-2",
                    titleAttr: 'Exportar CSV',
                    exportOptions: {
                        columns: ['th:not(:last-child):visible'],
                        orthogonal:"empleadoText"
                    }
                },
                {
                    extend: 'excelHtml5',
                    title: `Evidencia de Asignación de Recursos al SGSI ${new Date().toLocaleDateString().trim()}`,
                    text: '<i class="fas fa-file-excel" style="font-size: 1.1rem;color:#0f6935"></i>',
                    className: "btn-sm rounded pr-2",
                    titleAttr: 'Exportar Excel',
                    exportOptions: {
                        columns: ['th:not(:last-child):visible'],
                        orthogonal:"empleadoText"
                    }
                },
                {
                    extend: 'pdfHtml5',
                    title: `Evidencia de Asignación de Recursos al SGSI ${new Date().toLocaleDateString().trim()}`,
                    text: '<i class="fas fa-file-pdf" style="font-size: 1.1rem;color:#e3342f"></i>',
                    className: "btn-sm rounded pr-2",
                    titleAttr: 'Exportar PDF',
                    orientation: 'landscape',
                    exportOptions: {
                        columns: ['th:not(:last-child):visible'],
                        orthogonal:"empleadoText"
                    },
                    customize: function(doc) {
                        doc.pageMargins = [20, 60, 20, 30];
                        // doc.styles.tableHeader.fontSize = 7.5;
                        // doc.defaultStyle.fontSize = 7.5; //<-- set fontsize to 16 instead of 10
                    }
                },
                {
                    extend: 'print',
                    title: `Evidencia de Asignación de Recursos al SGSI ${new Date().toLocaleDateString().trim()}`,
                    text: '<i class="fas fa-print" style="font-size: 1.1rem;"></i>',
                    className: "btn-sm rounded pr-2",
                    titleAttr: 'Imprimir',
                    exportOptions: {
                        columns: ['th:not(:last-child):visible'],
                        orthogonal:"empleadoText"
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
            @can('evidencias_sgsi_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
                let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.evidencias-sgsis.massDestroy') }}",
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
            @can('evidencias_sgsi_delete')
                let btnAgregar = {
                text: '<i class="pl-2 pr-3 fas fa-plus"></i> Agregar',
                titleAttr: 'Agregar nueva Evidencia de Asignación de Recursos al SGSI',
                url: "{{ route('admin.evidencias-sgsis.create') }}",
                className: "btn-xs btn-outline-success rounded ml-2 pr-3",
                action: function(e, dt, node, config){
                let {url} = config;
                window.location.href = url;
                }
                };
                dtButtons.push(btnAgregar);
            @endcan
            let dtOverrideGlobals = {
                buttons: dtButtons,
                processing: true,
                serverSide: true,
                retrieve: true,
                aaSorting: [],
                ajax: "{{ route('admin.evidencias-sgsis.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'nombredocumento',
                        name: 'nombredocumento'
                    },
                    {
                        data: 'objetivodocumento',
                        name: 'objetivodocumento'
                    },
                    {
                        data: 'responsable_name',
                        name: 'responsable_name',
                        render: function(data, type, row, meta) {
                            if (type==="empleadoText") {
                                return row.empleado.name;
                            }
                            let responsablereunion = "";
                            if (row.empleado) {
                                responsablereunion += `
                            <img src="{{ asset('storage/empleados/imagenes') }}/${row.empleado.avatar}" title="${row.empleado.name}" class="rounded-circle" style="clip-path: circle(15px at 50% 50%);height: 30px;" />
                            `;
                            }
                            return responsablereunion;
                        }
                    },
                    {
                        data: 'area',
                        render: function(data, type, row, meta) {
                            console.log(row)
                            return JSON.parse(row.area).area;
                        }

                    },
                    {
                        data: 'fecha_documento',
                        name: 'fecha_documento'
                    },
                    {
                        data: 'evidencia',
                        name: 'evidencia',
                        render:function(data,type,row,meta){
                             let archivo="";
                             let archivos= JSON.parse(data);
                               archivo=` <div class="container">

                                    <div class="mb-4 row">
                                    <div class="text-center col">
                                        <a href="#" class="btn btn-sm btn-primary tamaño" data-toggle="modal" data-target="#largeModal${row.id}"><i class="mr-2 text-white fas fa-file" style="font-size:13pt"></i>Visualizar&nbsp;evidencias</a>
                                    </div>
                                    </div>

                                    <!-- modal -->
                                    <div class="modal fade" id="largeModal${row.id}" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                        <div class="modal-body">`;
                                            if(archivos.length>0){
                                                archivo+=`
                                            <!-- carousel -->
                                            <div
                                                id='carouselExampleIndicators${row.id}'
                                                class='carousel slide'
                                                data-ride='carousel'
                                                >
                                            <ol class='carousel-indicators'>
                                                    ${archivos?.map((archivo,idx)=>{
                                                        return `
                                                    <li
                                                    data-target='#carouselExampleIndicators${row.id}'
                                                    data-slide-to='${idx}'
                                                    ></li>`
                                                    })}
                                            </ol>
                                            <div class='carousel-inner'>
                                                    ${archivos?.map((archivo,idx)=>{
                                                        return `
                                                    <div class='carousel-item ${idx==0?"active":""}'>
                                                        <iframe seamless class='img-size' src='{{asset("storage/evidencias_sgsi")}}/${archivo.evidencia}'></iframe>
                                                    </div>`
                                                    })}

                                            </div>

                                            </div>`;
                                        }
                                            else{
                                                archivo+=`
                                                <div class="text-center">
                                                    <h3 style="text-align:center" class="mt-3">Sin archivo agregado</h3>
                                                    <img src="{{asset('img/undrawn.png')}}" class="img-fluid " style="width:500px !important">
                                                    </div>
                                                `
                                            }
                                            archivo+=`</div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                            <a
                                                class='carousel-control-prev'
                                                href='#carouselExampleIndicators${row.id}'
                                                role='button'
                                                data-slide='prev'
                                                >
                                                <span class='carousel-control-prev-icon'
                                                    aria-hidden='true'
                                                    ></span>
                                                <span class='sr-only'>Previous</span>
                                            </a>
                                            <a
                                                class='carousel-control-next'
                                                href='#carouselExampleIndicators${row.id}'
                                                role='button'
                                                data-slide='next'
                                                >
                                                <span
                                                    class='carousel-control-next-icon'
                                                    aria-hidden='true'
                                                    ></span>
                                                <span class='sr-only'>Next</span>
                                            </a>
                                        </div>
                                        </div>
                                    </div>
                                    </div>`
                            return archivo;
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
                ]
            };
            let table = $('.datatable-EvidenciasSgsi').DataTable(dtOverrideGlobals);
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
