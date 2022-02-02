@extends('layouts.admin')
@section('content')
	<h5 class="col-12 titulo_general_funcion">Lista de Documentos de Empleados</h5>
	@include('partials.flashMessages')
	<div class="card card-body">
		<div class="datatable-fix">
			<div class="w-100 text-right">
				<div class="btn btn-success" data-toggle="modal" data-target="#modal_crear_doc_e">Agregar</div>
			</div>
			<table class="table table-bordered w-100 datatable datatable-Perfiles" id="tabla_list_docs">
				<thead class="thead-dark">
					<tr>
						<th>Documento</th>
						<th style="max-width:100px;">ID activo</th>						
						<th style="max-width:100px;">Opciones</th>						
					</tr>
				</thead>
				<tbody>
					@foreach($docs as $doc)
						<tr>
							<td>{{ $doc->documento }}</td>
							<td>
								@if($doc->activar_numero == true)
									Obligatorio
								@endif
								@if($doc->activar_numero == false)
									Opcional
								@endif
							</td>
							<td>
								<a href="{{ asset('admin/lista-documentos/destroy') }}/{{ $doc->id }}"><i class="fas fa-trash-alt" style="font-size:15pt; color:#ED5A5A;"></i></a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>

	{{-- modal crar --}}
	<div class="modal fade" id="modal_crear_doc_e" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <form method="POST" action="{{ route('admin.lista-documentos-empleados-store') }}" class="modal-content">
	    	@csrf
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Agregar Documento a Lista</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <div class="form-group">
	        	<label><i class="far fa-file-alt iconos-crear"></i>Nombre del documento</label>
	        	<input type="" name="documento" class="form-control">
	        </div>
	        <div class="form-group">
	        	<label><i class="far fa-file-alt iconos-crear"></i>ID obligatorio</label>
	        	<input type="checkbox" name="activar_numero" class="form-control">
	        </div>
	      </div>
	      <div class="modal-footer">
	        <div type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</div>
	        <button class="btn btn-primary">Guardar</button>
	      </div>
	    </form>
	  </div>
	</div>

@endsection
@section('scripts')
	@parent
	<script type="text/javascript">
		$(function() {
            let dtButtons = [{
                    extend: 'csvHtml5',
                    title: `Inventario de Activos ${new Date().toLocaleDateString().trim()}`,
                    text: '<i class="fas fa-file-csv" style="font-size: 1.1rem; color:#3490dc"></i>',
                    className: "btn-sm rounded pr-2",
                    titleAttr: 'Exportar CSV',
                    exportOptions: {
                        columns: ['th:not(:last-child):visible']
                    }
                },
                {
                    extend: 'excelHtml5',
                    title: `Inventario de Activos ${new Date().toLocaleDateString().trim()}`,
                    text: '<i class="fas fa-file-excel" style="font-size: 1.1rem;color:#0f6935"></i>',
                    className: "btn-sm rounded pr-2",
                    titleAttr: 'Exportar Excel',
                    exportOptions: {
                        columns: ['th:not(:last-child):visible']
                    }
                },
                {
                    extend: 'pdfHtml5',
                    title: `Inventario de Activos ${new Date().toLocaleDateString().trim()}`,
                    text: '<i class="fas fa-file-pdf" style="font-size: 1.1rem;color:#e3342f"></i>',
                    className: "btn-sm rounded pr-2",
                    titleAttr: 'Exportar PDF',
                    orientation: 'portrait',
                    exportOptions: {
                        columns: ['th:not(:last-child):visible']
                    },
                    customize: function(doc) {
                        doc.pageMargins = [5, 20, 5, 20];
                        doc.styles.tableHeader.fontSize = 10;
                        doc.defaultStyle.fontSize = 10; //<-- set fontsize to 16 instead of 10
                    }
                },
                {
                    extend: 'print',
                    title: `Inventario de Activos ${new Date().toLocaleDateString().trim()}`,
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
                text: '<i class="pl-2 pr-3 fas fa-plus"></i> Agregar',
                titleAttr: 'Agregar empleado',
                url: "{{asset('admin/inicioUsuario/reportes/seguridad')}}",
                className: "btn-xs btn-outline-success rounded ml-2 pr-3",
                action: function(e, dt, node, config) {
                let {
                url
                } = config;
                window.location.href = url;
                }
            };


            let dtOverrideGlobals = {
                buttons: dtButtons,
                order:[
                            [0,'desc']
                        ]
            };
            let table = $('#tabla_list_docs').DataTable(dtOverrideGlobals);
        });
	</script>
@endsection