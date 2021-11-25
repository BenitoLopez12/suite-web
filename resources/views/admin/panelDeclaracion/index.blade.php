@extends('layouts.admin')
@section('content')

<style>
    .select-revisores .select2-selection {
        height: 50px !important;
    }

    .select-revisores .select2-selection,
    .select-revisores textarea {
        border: 2px solid #0b9095 !important;
        height: 50px !important;
    }

    .labels-publicacion {
        color: #0b9095 !important;
        font-weight: normal !important;
    }


    .table tr td:nth-child(3){
        min-width:300px !important;
    }

    .table tr td:nth-child(4){
            min-width:300px !important;
    }

</style>


@include('partials.flashMessages')

<div class="mt-5 card">
    <div class="py-3 col-md-10 col-sm-9 card card-body bg-primary align-self-center " style="margin-top:-40px; ">
        <h3 class="mb-2 text-center text-white"><strong>Controles</strong></h3>
    </div>

    <div class="card-body datatable-fix">
        <table class="table table-bordered w-100 datatable datatable-PanelDeclaracion">
            <thead class="thead-dark">
                <tr>
                    <th>
                        No
                    </th>
                    <th>
                        Control
                     </th>
                    <th>
                       Responsable
                    </th>
                    <th>
                        Aprobador
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
            //let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            let dtButtons = [{
                    extend: 'csvHtml5',
                    title: `Panel de Declaracion ${new Date().toLocaleDateString().trim()}`,
                    text: '<i class="fas fa-file-csv" style="font-size: 1.1rem; color:#3490dc"></i>',
                    className: "btn-sm rounded pr-2",
                    titleAttr: 'Exportar CSV',
                    exportOptions: {
                        columns: ['th:not(:last-child):visible']
                    }
                },
                {
                    extend: 'excelHtml5',
                    title: `Panel de Declaracion ${new Date().toLocaleDateString().trim()}`,
                    text: '<i class="fas fa-file-excel" style="font-size: 1.1rem;color:#0f6935"></i>',
                    className: "btn-sm rounded pr-2",
                    titleAttr: 'Exportar Excel',
                    exportOptions: {
                        columns: ['th:not(:last-child):visible']
                    }
                },
                {
                    extend: 'pdfHtml5',
                    title: `Panel de Declaracion ${new Date().toLocaleDateString().trim()}`,
                    text: '<i class="fas fa-file-pdf" style="font-size: 1.1rem;color:#e3342f"></i>',
                    className: "btn-sm rounded pr-2",
                    titleAttr: 'Exportar PDF',
                    orientation: 'landscape',
                    exportOptions: {
                        columns: ['th:not(:last-child):visible']
                    },
                    customize: function(doc) {
                        doc.pageMargins = [20, 60, 20, 30];
                        doc.styles.tableHeader.fontSize = 7.5;
                        doc.defaultStyle.fontSize = 7.5; //<-- set fontsize to 16 instead of 10
                    }
                },
                {
                    extend: 'print',
                    title: `Panel de Declaracion ${new Date().toLocaleDateString().trim()}`,
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
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.paneldeclaracion.massDestroy') }}",
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


            // let btnAgregar = {
            //     text: '<i class="pl-2 pr-3 fas fa-plus"></i> Agregar',
            //     titleAttr: 'Agregar nuevo',
            //     url: "{{ route('admin.paneldeclaracion.create') }}",
            //     className: "btn-xs btn-outline-success rounded ml-2 pr-3",
            //     action: function(e, dt, node, config) {
            //         let {
            //             url
            //         } = config;
            //         window.location.href = url;
            //     }
            // };
            // dtButtons.push(btnAgregar);


            let dtOverrideGlobals = {
                buttons: dtButtons,
                processing: true,
                serverSide: true,
                retrieve: true,
                aaSorting: [],
                dom: "<'row align-items-center justify-content-center'<'col-12 col-sm-12 col-md-3 col-lg-3 m-0'l><'text-center col-12 col-sm-12 col-md-6 col-lg-6'B><'col-md-3 col-12 col-sm-12 m-0'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row align-items-center justify-content-end'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6 d-flex justify-content-end'p>>",
                ajax: "{{ route('admin.paneldeclaracion.index') }}",
                columns: [{
                        data: 'controles',
                        name: 'controles'
                    },
                    {
                        data: 'politica',
                        name: 'politica'
                    },
                    {
                        data: 'responsable',
                        name: 'responsable',
                        render: function(data, type,row, meta) {
                         let responsableselect ="";
                         let responsableselects = JSON.parse(row.empleados);
                         console.log(row.empleados.declaraciones_responsable);
                         responsableselect =`
                            <select class="revisoresSelect" id='responsables${row.id}'' name="responsables[]" multiple="multiple" data-id='${row.id}'>
                                ${responsableselects?.map ((responsableselect,idx)=>{
                                    return`
                                    <option data-image='${responsableselect.foto}' data-id-empleado='${responsableselect.id}' data-gender='${responsableselect.genero}'>
                                        ${responsableselect.name }</option>`})}
                            </select>`;
                             $(`select#responsables${row.id}`).select2({
                                theme: 'bootstrap4',
                                templateResult: formatState,
                                templateSelection: formatState
                            });
                            $(`select#responsables${row.id}`).on('select2:select', function (e) {
                                const declaracion=this.getAttribute('data-id');
                                const {element}=e.params.data;
                                const responsable=element.getAttribute('data-id-empleado')
                                const url="{{route('admin.paneldeclaracion.responsables')}}";
                                const token="{{ csrf_token() }}";
                                const request= fetch(url,{
                                    mode: 'cors', // this cannot be 'no-cors'
                                    headers: {
                                        'X-CSRF-TOKEN': token,
                                        'Accept': 'application/json',
                                        'Content-Type': 'application/json',
                                    },
                                    method: 'POST',
                                    body: JSON.stringify({ declaracion, responsable })
                                });
                                request.then(response=>response.json()).
                                then(data=>{
                                    console.log(data)
                                }).
                                catch(error=>console.log)
                                console.log(empleadoId);
                            });
                                    return responsableselect;
                        }
                    },
                    {
                        data: 'aprobador',
                        name: 'aprobador',
                        render: function(data, type,row, meta) {
                        let aprobadorselect ="";
                        let aprobadoreselects = JSON.parse(row.empleados);
                        aprobadorselect  =`
                        <select class="revisoresSelect" id='aprobadores${row.id}'' name="aprobadores[]" multiple="multiple">
                            ${aprobadoreselects?.map ((aprobadorselect,idx)=>{
                                return`
                                <option data-image='${aprobadorselect.foto}' data-id-empleado='${aprobadorselect.id}' data-gender='${aprobadorselect.genero}'>
                                    ${aprobadorselect.name }</option>`})}
                                </select>`;
                                $(`select#aprobadores${row.id}`).select2({
                                theme: 'bootstrap4',
                                templateResult: formatState,
                                templateSelection: formatState
                            });
                            $(`select#aprobadores${row.id}`).on('select2:select', function (e) {
                                const declaracion=this.getAttribute('data-id');
                                const {element}=e.params.data;
                                const aprobador=element.getAttribute('data-id-empleado')
                                const url="{{route('admin.paneldeclaracion.aprobadores')}}";
                                const token="{{ csrf_token() }}";
                                const request= fetch(url,{
                                    mode: 'cors', // this cannot be 'no-cors'
                                    headers: {
                                        'X-CSRF-TOKEN': token,
                                        'Accept': 'application/json',
                                        'Content-Type': 'application/json',
                                    },
                                    method: 'POST',
                                    body: JSON.stringify({ declaracion, aprobador })
                                });
                                request.then(response=>response.json()).
                                then(data=>{
                                    console.log(data)
                                }).
                                catch(error=>console.log)
                                console.log(empleadoId);
                            });
                            return aprobadorselect;
                        }
                    },
                    {
                        data: 'actions',
                        name: '{{ trans('global.actions') }}'
                    }
                ],
                orderCellsTop: true,
                order: [
                    [4, 'desc']
                ]
            };
            let table = $('.datatable-PanelDeclaracion').DataTable(dtOverrideGlobals);
              // buttons: dtButtons
            // })
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



    document.addEventListener('DOMContentLoaded', function() {
        $('select').select2({
            theme: 'bootstrap4',
        });

        $('select.empleado').select2({
            theme: 'bootstrap4',
            templateResult: formatState,
            templateSelection: formatState
        });

        $('.revisoresSelect').select2({
            theme: 'bootstrap4',
            templateResult: formatState,
            templateSelection: formatStateMulti
        });

    });

    window.formatStateMulti=(opt)=> {
        if (!opt.id) {
            return opt.text;
        }

        var optimage = $(opt.element).attr('data-image');
        var gender = $(opt.element).attr('data-gender');
        if (!optimage) {
            let foto = 'ususario_no_cargado.png'
            if (gender == 'M') {
                foto = 'woman.png';
            }

            if (gender == 'H') {
                foto = 'man.png';
            }

            var $opt = $(
                '<span><img src="{{ asset('storage/empleados/imagenes/') }}/' + foto +
                '" class="img-fluid rounded-circle" width="30" height="30"/></span>'
            );
            return $opt;
        } else {
            var $opt = $(
                '<span><img src="{{ asset('storage/empleados/imagenes/') }}/' + optimage +
                '" class="img-fluid rounded-circle" width="30" height="30"/></span>'
            );
            return $opt;
        }
    };

    window.formatState=(opt)=> {
        if (!opt.id) {
            return opt.text;
        }

        var optimage = $(opt.element).attr('data-image');
        var gender = $(opt.element).attr('data-gender');
        if (!optimage) {
            let foto = 'ususario_no_cargado.png'
            if (gender == 'M') {
                foto = 'woman.png';
            }

            if (gender == 'H') {
                foto = 'man.png';
            }

            var $opt = $(
                '<span><img src="{{ asset('storage/empleados/imagenes/') }}/' + foto +
                '" class="img-fluid rounded-circle" width=25 height=25/> ' +
                opt.text + '</span>'
            );
            return $opt;
        } else {
            var $opt = $(
                '<span><img src="{{ asset('storage/empleados/imagenes/') }}/' + optimage +
                '" class="img-fluid rounded-circle" width=25 height=25/> ' +
                opt.text + '</span>'
            );
            return $opt;
        }
    };

    </script>


@endsection
