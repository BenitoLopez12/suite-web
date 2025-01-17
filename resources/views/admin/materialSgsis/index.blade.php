@extends('layouts.admin')
@section('content')

    <style>

        .btn-outline-success {
            background: #788bac !important;
            color: white;
            border: none;
        }

        .btn-outline-success:focus {
            border-color: #345183 !important;
            box-shadow: none;
        }

        .btn-outline-success:active {
            box-shadow: none !important;
        }

        .btn-outline-success:hover {
            background: #788bac;
            color: white;

        }

        .btn_cargar {
            border-radius: 100px !important;
            border: 1px solid #345183;
            color: #345183;
            text-align: center;
            padding: 0;
            width: 35px;
            height: 35px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 !important;
            margin-right: 10px !important;
        }
        .img-size {
            /* 	padding: 0;
            margin: 0; */
            height: 450px;
            width: 700px;
            background-size: cover;
            overflow: hidden;
        }

        .modal-content {
            width: 700px;
            border: none;
        }

        .modal-body {
            padding: 0;
        }

        .carousel-control-prev-icon {
            background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23009be1' viewBox='0 0 8 8'%3E%3Cpath d='M5.25 0l-4 4 4 4 1.5-1.5-2.5-2.5 2.5-2.5-1.5-1.5z'/%3E%3C/svg%3E");
            width: 30px;
            height: 48px;
        }

        .carousel-control-next-icon {
            background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23009be1' viewBox='0 0 8 8'%3E%3Cpath d='M2.75 0l-1.5 1.5 2.5 2.5-2.5 2.5 1.5 1.5 4-4-4-4z'/%3E%3C/svg%3E");
            width: 30px;
            height: 48px;
        }

        .carousel-control-next {
            top: 100px;
            height: 10px;
        }

        .carousel-control-prev {
            height: 40px;
            top: 80px;
        }

        .table tr td:nth-child(6) {

            max-width: 415px !important;
            width: 415px !important;

        }

        /* se comento por que se descuadra la cabecera de la tabla y el registro */
        /* .table tr th:nth-child(6){

            width:415px !important;
            max-width:415px !important;
        } */

        .table tr td:nth-child(2) {

        min-width:300px !important;
        text-align: justify !important;

        }

        .table tr th:nth-child(2) {

        text-align: center !important;

        }
        .table tr td:nth-child(3) {

            min-width:500px !important;
            text-align: justify !important;

        }

        .table tr th:nth-child(3) {

        text-align: center !important;

        }

        .table tr td:nth-child(5) {

            text-align: justify !important;


        }

        .table tr td:nth-child(10) {

            text-align: center;

        }

        .tamaño {

            width: 168px !important;

        }

    </style>



    {{ Breadcrumbs::render('admin.material-sgsis.index') }}

    <h5 class="col-12 titulo_general_funcion">Material SGSI  </h5>
    <div class="card card-body" style="background-color: #5397D5; color: #fff;">
        <div class="d-flex" style="gap: 25px;">
            <img src="{{ asset('img/audit_port.jpg') }}" alt="Auditoria" style="width: 200px;">
            <div>
                <br>
                <h4>¿Qué es Material SGSI?</h4>
                <p>
                    Recursos educativos diseñados para enseñar a los colaboradores sobre las prácticas y requisitos de seguridad de la información establecidos por la norma.
                </p>
                <p>
                    Útil para crear y mantener programas de formación y concientización en seguridad de la información.
                </p>
            </div>
        </div>
    </div>

        <div class="text-right">
            <div class="d-flex justify-content-end">
                <a href="{{ route('admin.material-sgsis.create') }}" type="button" class="btn tb-btn-primary">Registrar Material</a>
            </div>
        </div>
        <div class="mt-5 card">
            {{-- <div style="margin-bottom: 10px; margin-left:10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.material-sgsis.create') }}">
                    Agregar <strong>+</strong>
            </a>
        </div>
    </div> --}}
        @include('partials.flashMessages')
        <div class="card-body datatable-fix">
            <table class="table table-bordered w-100 datatable-MaterialSgsi">
                <thead class="thead-dark">
                    <tr>
                        <th>
                            {{ trans('cruds.materialSgsi.fields.id') }}
                        </th>
                        <th>
                            Nombre&nbsp;del&nbsp;material
                        </th>
                        <th>
                            {{ trans('cruds.materialSgsi.fields.objetivo') }}
                        </th>
                        <th>
                            Personal&nbsp;Objetivo
                        </th>
                        <th>
                            Area&nbsp;Responsable
                        </th>
                        <th>
                            Tipo&nbsp;de&nbsp;Impartición
                        </th>
                        <th>
                            Fecha&nbsp;de&nbsp;creación&nbsp;o&nbsp;actualización
                        </th>
                        <th>
                            Material&nbsp;(Archivo&nbsp;PDF)
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
                            <select class="search" strict="true">
                                <option value>{{ trans('global.all') }}</option>
                                @foreach (App\Models\MaterialSgsi::PERSONALOBJETIVO_SELECT as $key => $item)
                                    <option value="{{ $key }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select class="search">
                                <option value>{{ trans('global.all') }}</option>
                                @foreach ($areas as $key => $item)
                                    <option value="{{ $item->area }}">{{ $item->area }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select class="search" strict="true">
                                <option value>{{ trans('global.all') }}</option>
                                @foreach (App\Models\MaterialSgsi::TIPOIMPARTICION_SELECT as $key => $item)
                                    <option value="{{ $key }}">{{ $item }}</option>
                                @endforeach
                            </select>
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
                    title: `Material SGSI ${new Date().toLocaleDateString().trim()}`,
                    text: '<i class="fas fa-file-csv" style="font-size: 1.1rem; color:#3490dc"></i>',
                    className: "btn-sm rounded pr-2",
                    titleAttr: 'Exportar CSV',
                    exportOptions: {
                        columns: ['th:not(:last-child):visible']
                    }
                },
                {
                    extend: 'excelHtml5',
                    title: `Material SGSI ${new Date().toLocaleDateString().trim()}`,
                    text: '<i class="fas fa-file-excel" style="font-size: 1.1rem;color:#0f6935"></i>',
                    className: "btn-sm rounded pr-2",
                    titleAttr: 'Exportar Excel',
                    exportOptions: {
                        columns: ['th:not(:last-child):visible']
                    }
                },
                // {
                //     extend: 'pdfHtml5',
                //     title: `Material SGSI ${new Date().toLocaleDateString().trim()}`,
                //     text: '<i class="fas fa-file-pdf" style="font-size: 1.1rem;color:#e3342f"></i>',
                //     className: "btn-sm rounded pr-2",
                //     titleAttr: 'Exportar PDF',
                //     orientation: 'portrait',
                //     exportOptions: {
                //         columns: ['th:not(:last-child):visible']
                //     },
                //     customize: function(doc) {
                //         doc.pageMargins = [20, 60, 20, 30];
                //         // doc.styles.tableHeader.fontSize = 7.5;
                //         // doc.defaultStyle.fontSize = 7.5; //<-- set fontsize to 16 instead of 10
                //     }
                // },
                {
                    extend: 'print',
                    title: `Material SGSI ${new Date().toLocaleDateString().trim()}`,
                    text: '<i class="fas fa-print" style="font-size: 1.1rem;"></i>',
                    className: "btn-sm rounded pr-2",
                    titleAttr: 'Imprimir',
                    customize: function(doc) {
                        let logo_actual = @json($logo_actual);
                        let empresa_actual = @json($empresa_actual);

                        var now = new Date();
                        var jsDate = now.getDate() + '-' + (now.getMonth() + 1) + '-' + now.getFullYear();
                        $(doc.document.body).prepend(`
                        <div class="row mt-5 mb-4 col-12 ml-0" style="border: 2px solid #ccc; border-radius: 5px">
                            <div class="col-2 p-2" style="border-right: 2px solid #ccc">
                                    <img class="img-fluid" style="max-width:120px" src="${logo_actual}"/>
                                </div>
                                <div class="col-7 p-2" style="text-align: center; border-right: 2px solid #ccc">
                                    <p>${empresa_actual}</p>
                                    <strong style="color:#345183">MATERIAL SGSI</strong>
                                </div>
                                <div class="col-3 p-2">
                                    Fecha: ${jsDate}
                                </div>
                            </div>
                        `);

                        $(doc.document.body).find('table')
                            .css('font-size', '12px')
                            .css('margin-top', '15px')
                        // .css('margin-bottom', '60px')
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

            @can('material_sgsi_agregar')
                // let btnAgregar = {
                // text: '<i class="pl-2 pr-3 fas fa-plus"></i> Agregar',
                // titleAttr: 'Agregar material SGSI',
                // url: "{{ route('admin.material-sgsis.create') }}",
                // className: "btn-xs btn-outline-success rounded ml-2 pr-3",
                // action: function(e, dt, node, config){
                // let {url} = config;
                // window.location.href = url;
                // }
                // };
                // dtButtons.push(btnAgregar);
            @endcan
            @can('material_sgsi_eliminar')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
                let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.material-sgsis.massDestroy') }}",
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
                ajax: "{{ route('admin.material-sgsis.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'nombre',
                        name: 'nombre'
                    },
                    {
                        data: 'objetivo',
                        name: 'objetivo'
                    },
                    {
                        data: 'personalobjetivo',
                        name: 'personalobjetivo'
                    },
                    {
                        data: 'arearesponsable_area',
                        name: 'arearesponsable.area'
                    },
                    {
                        data: 'tipoimparticion',
                        name: 'tipoimparticion'
                    },
                    {
                        data: 'fechacreacion_actualizacion',
                        name: 'fechacreacion_actualizacion'
                    },
                    {
                        data: 'documento',
                        name: 'documento',
                        render: function(data, type, row, meta) {
                            let archivo = "";
                            let archivos = JSON.parse(data);
                            archivo = ` <div class="container">

                                    <div class="mb-4 row">
                                    <div class="text-center col">
                                        @can('material_sgsi_vinculo')
                                        <a href="#" class="btn btn-sm tb-btn-primary tamaño" data-toggle="modal" data-target="#largeModal${row.id}"><i class="mr-2 text-white fas fa-file" style="font-size:13pt"></i>Visualizar&nbsp;evidencias</a>
                                        @endcan
                                    </div>
                                    </div>

                                    <!-- modal -->
                                    <div class="modal fade" id="largeModal${row.id}" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                        <div class="modal-body">`;
                            if (archivos.length > 0) {
                                archivo += `
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
                                                        data-slide-to='${idx}'></li>`})}
                                            </ol>
                                            <div class='carousel-inner'>
                                                    ${archivos?.map((archivo,idx)=>{
                                                        const [extension, ...nameParts] = archivo.documento.split('.').reverse();
                                                        if(extension == 'pdf'){
                                                        return `
                                                        <div class='carousel-item ${idx==0?"active":""}'>
                                                            <embed seamless class='img-size' src='{{ asset('storage/documentos_material_sgsi') }}/${archivo.documento}'></embed>
                                                        </div>`
                                                    }else{
                                                        return `
                                                                    <div class='text-center my-5 carousel-item ${idx==0?"active":""}'>
                                                                       <a href='{{ asset("storage/documentos_material_sgsi") }}/${archivo.documento}'><i class="fas fa-file-download mr-2" style="font-size:18px"></i> ${archivo.documento}</a>
                                                                    </div>`
                                                    }
                                                    })}

                                            </div>

                                            </div>`;
                            } else {
                                archivo += `
                                                <div class="text-center">
                                                    <h3 style="text-align:center" class="mt-3">Sin archivo agregado</h3>
                                                    <img src="{{ asset('img/undrawn.png') }}" class="img-fluid " style="width:500px !important">
                                                    </div>
                                                `
                            }
                            archivo += `
                                        </div>
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
            let table = $('.datatable-MaterialSgsi').DataTable(dtOverrideGlobals);
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
