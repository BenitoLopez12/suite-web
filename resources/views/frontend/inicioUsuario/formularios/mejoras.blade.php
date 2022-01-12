@extends('layouts.frontend')
@section('content')
	<div class="card">
		<div class="text-center card-header" style="background-color: #345183;">
			<strong style="font-size: 16pt; color: #fff;"><i class="mr-4 fas fa-rocket"></i>Mejoras</strong>
		</div>
		<div class="card-body">
			<strong>INSTRUCCIONES:</strong> Por favor, conteste las siguientes preguntas y dé clic en el botón "Enviar"

			<form class="row" method="POST" action="{{ route('frontend.reportes-mejoras-store') }}">
				@csrf

				<div class="mt-4 form-group col-12">
					<b>Datos generales:</b>
				</div>

				<div class="mt-0 form-group col-4">
					<label class="form-label"><i class="fas fa-user iconos-crear"></i>Nombre</label>
					<div class="form-control">{{ auth()->user()->empleado->name }}</div>
				</div>

				<div class="mt-0 form-group col-4">
					<label class="form-label"><i class="fas fa-user-tag iconos-crear"></i>Puesto</label>
					<div class="form-control">{{ auth()->user()->empleado->puesto }}</div>
				</div>

				<div class="mt-0 form-group col-4">
					<label class="form-label"><i class="fas fa-puzzle-piece iconos-crear"></i></i>Área</label>
					<div class="form-control">{{ auth()->user()->empleado->area->area }}</div>
				</div>

				<div class="mt-4 form-group col-6">
					<label class="form-label"><i class="fas fa-envelope iconos-crear"></i>Correo electrónico</label>
					<div class="form-control">{{ auth()->user()->empleado->email }}</div>
				</div>

				<div class="mt-4 form-group col-6">
					<label class="form-label"><i class="fas fa-phone iconos-crear"></i>Teléfono</label>
					<div class="form-control">{{ auth()->user()->empleado->telefono }}</div>
				</div>

				<div class="mt-4 form-group col-12">
					<b>Mejora dirigida a:</b>
				</div>

				<div class="mt-1 form-group col-6 multiselect_areas">
                	<label class="form-label"><i class="fas fa-puzzle-piece iconos-crear"></i>Área(s)</label>
                    <select class="form-control" name="">
                        <option disabled selected>Seleccionar áreas</option>
                        @foreach ($areas as $area)
                            <option value="{{ $area->area }}">
                            	{{ $area->area }}
                            </option>
                        @endforeach
                    </select>
                    <textarea name="area_mejora" class="form-control"></textarea>
                </div>

                <div class="mt-1 form-group col-6 multiselect_procesos">
                	<label class="form-label"><i class="fas fa-dice-d20 iconos-crear"></i>Proceso(s)</label>
                    <select class="form-control" name="">
                        <option disabled selected>Seleccionar proceso</option>
                        @foreach ($procesos as $proceso)
                            <option value="{{ $proceso->codigo }}: {{ $proceso->nombre }}">
                            	{{ $proceso->codigo }}: {{ $proceso->nombre }}
                            </option>
                        @endforeach
                    </select>
                    <textarea name="proceso_mejora" class="form-control"></textarea>
                </div>

				<div class="mt-4 form-group col-12">
					<b>Descripción de la mejora:</b>
				</div>

				<div class="mt-1 form-group col-12">
					<label class="form-label"><i class="fas fa-text-width iconos-crear"></i>Título corto de la mejora</label>
					<input type="" name="titulo" class="form-control">
				</div>

				<div class="mt-2 form-group col-12 select_tipo">
					<label class="form-label"><i class="fas fa-rocket iconos-crear"></i>Propuesta de mejora para un: </label>
					<select name="tipo" class="form-control">
						<option>Proceso interno/externo</option>
						<option>Producto</option>
						<option>Servicio</option>
						<option>Modelo de negocio</option>
						<option value="otra">Otro</option>
					</select>
				</div>

				<div class="mt-2 form-group col-4 otra" style="display: none;">
					<label class="form-label">¿Cuál?</label>
					<input type="" name="otro" class="form-control">
				</div>

				<div class="mt-4 form-group col-12">
					<label class="form-label"><i class="fas fa-file-alt iconos-crear"></i>Describa detalladamente la mejora propuesta</label>
					<textarea name="descripcion" class="form-control"></textarea>
				</div>

				<div class="mt-4 form-group col-12">
					<label class="form-label"><i class="fas fa-file-alt iconos-crear"></i>Beneficios de la mejora</label>
					<textarea name="beneficios" class="form-control"></textarea>
				</div>

				<div class="mt-4 text-right form-group col-12">
					<a href="{{ asset('frontend/inicioUsuario') }}" class="btn btn_cancelar">Cancelar</a>
					<input type="submit" name="" class="btn btn-success" value="Enviar">
				</div>

			</form>
		</div>
	</div>
@endsection

@section('scripts')
	<script type="text/javascript">
		document.addEventListener('DOMContentLoaded', function() {

		    document.querySelector('.select_tipo select').addEventListener('change', function(e) {
		        e.preventDefault();
		        console.log(e.target.value);
		        if(e.target.value == 'otra'){
		        	$(".select_tipo").removeClass('col-12');
		        	$(".select_tipo").addClass('col-8')
		        	$(".otra").show(100);
		        }
		        else{
		        	$(".otra").hide(0);
		        	$(".select_tipo").removeClass('col-8');
		        	$(".select_tipo").addClass('col-12')
		        }

		    });
	   	});
	</script>



	<script type="text/javascript">
		document.addEventListener('DOMContentLoaded', function(){
			let select_activos = document.querySelector('.multiselect_areas select');
			select_activos.addEventListener('change', function(e){
				e.preventDefault();
				let texto_activos = document.querySelector('.multiselect_areas textarea');

					texto_activos.value += `${this.value}, `;

			});
		});


		document.addEventListener('DOMContentLoaded', function(){
			let select_activos = document.querySelector('.multiselect_procesos select');
			select_activos.addEventListener('change', function(e){
				e.preventDefault();
				let texto_activos = document.querySelector('.multiselect_procesos textarea');

					texto_activos.value += `${this.value}, `;

			});
		});
	</script>
@endsection
