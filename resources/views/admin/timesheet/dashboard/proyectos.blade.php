<div class="row">
	<div class=" col-md-4 p-4">
		<h4 class="titulo-grafica d-flex justify-content-between">Proyectos <a href="{{ asset('admin/timesheet/reportes') }}">Ver detalle</a></h4>
		<canvas id="graf-proyectos-estatus" width="400" height="400"></canvas>
	</div>
	<div class=" col-md-8 p-4">
		<h4 class="titulo-grafica d-flex justify-content-between">Horas invertidas a proyectos en proceso <a href="{{ asset('admin/timesheet/reportes') }}">Ver detalle</a></h4>
		<canvas id="graf-proyectos-horas" width="800" height="400"></canvas>
	</div>
</div>
<div class="row">
	<div class=" col-md-4 p-4">
		<h4 class="titulo-grafica d-flex justify-content-between">Horas invertidas en proyectos por estatus <a href="{{ asset('admin/timesheet/reportes') }}">Ver detalle</a></h4>
		<canvas id="graf-proyectos" width="400" height="400"></canvas>
	</div>
	<div class=" col-md-8 p-4">
		<h4 class="titulo-grafica d-flex justify-content-between">Tareas por proyectos en proceso <a href="{{ asset('admin/timesheet/reportes') }}">Ver detalle</a></h4>
		<canvas id="graf-proyectos-tareas" width="800" height="400"></canvas>
	</div>
</div>
<script>
	new Chart(document.getElementById('graf-proyectos-estatus'), {
	    type: 'doughnut',
	    data: {
	        labels: ['En proceso', 'Cancelados', 'Terminados'],
	        datasets: [{
	            label: '%',
	            data: [{{ $proyectos_proceso_c }}, {{ $proyectos_cancelados_c }}, {{ $proyectos_terminados_c }}],
	            backgroundColor: [
	                '#F48C16',
	                '#bbb',
	                '#61CB5C',
	            ],
	        }]
	    },
	    options: {
	        scales: {
	            y: {
	                beginAtZero: true
	            }
	        }
	    }
	});
</script>
<script>
	new Chart(document.getElementById('graf-proyectos-horas'), {
	    type: 'bar',
	    data: {
	        labels: [
	        	@foreach($proyectos_array as $proyecto_h)
	        		@if($proyecto_h['estatus'] == 'proceso')
	        			'{{ $proyecto_h['proyecto'] }}',
	        		@endif
	        	@endforeach
	        ],
	        datasets: [{
	            label: 'Horas',
	            data: [
		        	@foreach($proyectos_array as $proyecto_h)
	        			@if($proyecto_h['estatus'] == 'proceso')
		        			{{ $proyecto_h['horas'] }},
		        		@endif
		        	@endforeach
	        	],
	            backgroundColor: [
	            	@foreach($proyectos_array as $proyecto_h)
	            		@if($proyecto_h['estatus'] == 'proceso')
	                		'#34DCCF',
	                	@endif
	                @endforeach
	            ],
	        }]
	    },
	    options: {
	        scales: {
	            y: {
	                beginAtZero: true
	            }
	        }
	    }
	});
</script>
<script>
	new Chart(document.getElementById('graf-proyectos'), {
	    type: 'doughnut',
	    data: {
	        labels: ['En proceso', 'Cancelados', 'Terminados'],
	        datasets: [{
	            label: 'Horas',
	            data: [
	            	{{ $proyectos_proceso_array }}, {{ $proyectos_cancelado_array }}, {{ $proyectos_terminado_array }}
	            ],
	            backgroundColor: [
	                '#F48C16',
	                '#bbb',
	                '#61CB5C',
	            ],
	        }]
	    },
	    options: {
	        scales: {
	            y: {
	                beginAtZero: true
	            }
	        }
	    }
	});
</script>
<script>
	new Chart(document.getElementById('graf-proyectos-tareas'), {
	    type: 'bar',
	    data: {
	        labels: [
	        	@foreach($proyectos_array as $proyecto_h)
	        		'{{ $proyecto_h['proyecto'] }}',
	        	@endforeach
	        ],
	        datasets: [{
	            label: 'Tareas',
	            data: [
		        	@foreach($proyectos_array as $proyecto_h)
		        		{{ $proyecto_h['tareas_count'] }},
		        	@endforeach
	        	],
	            backgroundColor: [
	            	@foreach($proyectos_array as $proyecto_h)
	                	'#DCC334',
	                @endforeach
	            ],
	        }]
	    },
	    options: {
	        scales: {
	            y: {
	                beginAtZero: true
	            }
	        }
	    }
	});
</script>