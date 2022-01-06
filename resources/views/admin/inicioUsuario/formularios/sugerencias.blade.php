@extends('layouts.admin')
@section('content')
    <style>
        ol.breadcrumb {
            margin-bottom: 0px;
        }

    </style>
    {{ Breadcrumbs::render('sugerencias-create') }}
    {{-- <h5 class="col-12 titulo_general_funcion">Sugerencias</h5> --}}
    <div class="card">
        <div class="text-center card-header" style="background-color: #345183;">
            <strong style="font-size: 16pt; color: #fff;"><i class="mr-4 fas fa-lightbulb"></i>Sugerencias</strong>
        </div>
        <div class="card-body">
            <strong>INSTRUCCIONES:</strong> Por favor, conteste las siguientes preguntas y dé clic en el botón "Enviar"

            <form method="POST" action="{{ route('admin.reportes-sugerencias-store') }}" class="row">
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
                    <b>Sugerencia dirigida a:</b>
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
                    <textarea name="area_sugerencias" class="form-control"></textarea>
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
                    <textarea name="proceso_sugerencias" class="form-control"></textarea>
                </div>

                <div class="mt-4 form-group col-12">
                    <b>Descripción de la sugerencia:</b>
                </div>

                <div class="mt-2 form-group col-12">
                    <label class="form-label"><i class="fas fa-text-width iconos-crear"></i> Título corto de la
                        sugerencia</label>
                    <input name="titulo" class="form-control">
                </div>

                <div class="mt-2 form-group col-12">
                    <label class="form-label"><i class="fas fa-file-alt iconos-crear"></i> Describa detalladamente su
                        sugerencia</label>
                    <textarea name="descripcion" class="form-control"></textarea>
                </div>

                <div class="mt-2 text-right form-group col-12">
                    <a href="{{ asset('admin/inicioUsuario') }}#reportes" class="btn btn_cancelar">Cancelar</a>
                    <input type="submit" name="" class="btn btn-success" value="Enviar">
                </div>

            </form>
        </div>
    </div>
@endsection







@section('scripts')
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            let select_activos = document.querySelector('.multiselect_areas select');
            select_activos.addEventListener('change', function(e) {
                e.preventDefault();
                let texto_activos = document.querySelector('.multiselect_areas textarea');

                texto_activos.value += `${this.value}, `;

            });
        });


        document.addEventListener('DOMContentLoaded', function() {
            let select_activos = document.querySelector('.multiselect_procesos select');
            select_activos.addEventListener('change', function(e) {
                e.preventDefault();
                let texto_activos = document.querySelector('.multiselect_procesos textarea');

                texto_activos.value += `${this.value}, `;

            });
        });
    </script>
@endsection
