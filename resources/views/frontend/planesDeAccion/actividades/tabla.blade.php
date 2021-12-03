<style>
        .table tr th:nth-child(8){
        min-width:800px !important;
        text-align:justify !important;
        }

</style>


<div class="container w-100">
    <div class="mb-2 row">
        <div class="mb-4 ml-4 w-100" style="border-bottom: solid 2px #0CA193;">
            <span class="ml-1" style="font-size: 17px; font-weight: bold;">
                <i class="fas fa-stream"></i> Vincular Plan de Acción</span>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-lg-12 col-md-12">
            <div class="form-group">
                <label for="actividad"><i class="iconos-crear fas fa-stream"></i> Actividad <span
                        class="text-danger">*</span></label><i class="fas fa-info-circle" style="font-size:12pt; float: right;" title="Nombre de la actividad"></i>
                <div class="row align-items-center">
                    <div class="col-12">
                        <input type="text" class="form-control" id="actividad" name="actividad">
                    </div>
                    {{-- <div class="pr-0 col-1">
                        <button id="btnVincularNombre" class="btn btn-outline-primary btn-sm"
                            title="Vincular con nombre"><i class="fas fa-share"></i></button>
                    </div> --}}
                </div>
                {{-- <small id="actividadHelp" class="form-text text-muted">Nombre de la actividad</small> --}}
                <small class="p-0 m-0 text-xs error_actividad errores text-danger"></small>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-lg-6 col-6">
            <div class="form-group">
                <label for="inicio"><i class="iconos-crear fas fa-calendar-day"></i> Inicio <span
                        class="text-danger">*</span></label><i class="fas fa-info-circle" style="font-size:12pt; float: right;" title="Fecha de inicio de la actividad"></i>
                <input type="date" class="form-control" id="inicio" name="inicio">
                {{-- <small id="inicioHelp" class="form-text text-muted">Fecha de inicio de la actividad</small> --}}
                <small class="p-0 m-0 text-xs error_inicio errores text-danger"></small>
            </div>
        </div>
        <div class="col-sm-12 col-lg-6 col-6">
            <div class="form-group">
                <label for="finalizacion"><i class="iconos-crear fas fa-calendar-day"></i> Finalización <span
                        class="text-danger">*</span></label><i class="fas fa-info-circle" style="font-size:12pt; float: right;" title="Fecha de finalización de la
                        actividad"></i>
                <input type="date" class="form-control" id="finalizacion" name="finalizacion">
                {{-- <small id="finalizacionHelp" class="form-text text-muted">Fecha de finalización de la
                    actividad</small> --}}
                <small class="p-0 m-0 text-xs error_finalizacion errores text-danger"></small>
            </div>
        </div>
    </div>
        {{-- <div class="col-sm-12 col-lg-4 col-4">
            <div class="form-group">
                <label for="progreso"><i class="iconos-crear fas fa-percent"></i> Progreso <span
                        class="text-danger">*</span></label>
                <input type="number" class="form-control" id="progreso" name="progreso" min="0" max="100">
                <small id="progresoHelp" class="form-text text-muted">Progreso de la actividad, rango de 0 -
                    100</small>
                <small class="p-0 m-0 text-xs error_progreso errores text-danger"></small>
            </div>
        </div> --}}
    <div class="mb-3 row">
        <div class="col-sm-12 col-lg-12 col-md-12">
            <label for="responsables_actividad"><i class="iconos-crear fas fa-users"></i> Responsables <span
                    class="text-danger">*</span></label><i class="fas fa-info-circle" style="font-size:12pt; float: right;" title="Responsables de la actividad"></i>
            <select class="responsables_actividad" id="responsables_actividad" multiple>
                @foreach ($empleados as $empleado)
                    <option value="{{ $empleado->id }}" avatar="{{ $empleado->avatar }}">
                        {{ $empleado->name }}</option>
                @endforeach
            </select>
            {{-- <small id="responsables_actividadHelp" class="form-text text-muted">Responsables de la actividad</small> --}}
            <small class="p-0 m-0 text-xs error_participantes errores text-danger"></small>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 col-lg-12 col-md-12">
            <div class="form-group">
                <label for="comentarios"><i class="iconos-crear fas fa-comments"></i> Comentarios <span
                        class="text-danger">*</span></label><i class="fas fa-info-circle" style="font-size:12pt; float: right;" title="Comentarios de la actividad"></i>
                <textarea class="form-control w-100" id="comentarios" name="comentarios"></textarea>
                {{-- <small id="comentariosHelp" class="form-text text-muted">Comentarios de la actividad</small> --}}
                <small class="p-0 m-0 text-xs error_comentarios errores text-danger"></small>
            </div>
        </div>
    </div>
    <input type="hidden" id="actividades" name="actividades">

    <button id="btnAgregar" class="mt-3 mb-5 btn btn-sm btn-outline-success" style="float:right;"><i
            class="fas fa-plus-circle"></i> Agregar
        Actividad</button>
    @if ($errors->has('actividades'))
        <span class="text-danger">
            <i class="mr-2 fas fa-info-circle"></i>{{ $errors->first('actividades') }}
        </span>
    @endif
    <div class="mt-5 datatable-fix w-100">
        <table id="tblActividades" class="table w-100">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Actividad</th>
                    <th scope="col">Inicio</th>
                    <th scope="col">Finalización</th>
                    <th scope="col">Duración</th>
                    <th scope="col">Responsable(s)</th>
                    <th scope="col">Responsable(s)_id</th>
                    <th scope="col">Comentarios</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @if (isset($actividades))
                    @foreach ($actividades as $actividad)
                        <tr>
                            <td>{{ $actividad->id }}</td>
                            <td>{{ $actividad->name }}</td>
                            <td>{{ \Carbon\Carbon::parse(\Carbon\Carbon::createFromTimestamp(intval($actividad->start) / 1000)->toDateTimeString())->format('Y-m-d') }}
                            </td>
                            <td>{{ \Carbon\Carbon::parse(\Carbon\Carbon::createFromTimestamp(intval($actividad->end) / 1000)->toDateTimeString())->format('Y-m-d') }}
                            </td>
                            <td>{{ $actividad->duration }}</td>
                            <td>
                                @foreach ($actividad->assigs as $assig)
                                    @php
                                        $empleado = App\Models\Empleado::find(intval($assig->resourceId));
                                    @endphp
                                    <img src="{{ asset('storage/empleados/imagenes') }}/{{ $empleado->foto }}"
                                        id="res_{{ $empleado->id }}" alt="{{ $empleado->name }}"
                                        title="{{ $empleado->name }}"
                                        style="clip-path: circle(15px at 50% 50%);width: 45px;" />
                                @endforeach
                            </td>
                            <td>
                                @php
                                    $asignados = [];
                                    foreach ($actividad->assigs as $assig) {
                                        $empleado = App\Models\Empleado::find(intval($assig->resourceId));
                                        array_push($asignados, $empleado->id);
                                    }
                                @endphp
                                {{ str_replace('"', '', str_replace('[', '', str_replace(']', '', json_encode($asignados)))) }}
                            </td>
                            <td>{{ $actividad->description }}</td>
                            <td>
                                <button class="btn btn-sm text-danger" title="Eliminar actividad"
                                    onclick="event.preventDefault(); EliminarFila(this)"><i
                                        class="fa fa-trash-alt"></i></button>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        $(document).ready(function() {
            window.tblActividades = $('#tblActividades').DataTable({
                buttons: []
            });
        });
        $('.responsables_actividad').select2({
            theme: 'bootstrap4',
        });
        document.getElementById('btnAgregar').addEventListener('click', function(e) {
            e.preventDefault();
            limpiarErrores();
            agregarActividad();
        })

        // document.getElementById('btnVincularNombre').addEventListener('click', function(e) {
        //     e.preventDefault();
        //     let elementNombre = document.querySelector('[data-vincular-nombre="true"]').value;
        //     if (elementNombre != "") {
        //         if (document.getElementById('actividad').value == "") {
        //             document.getElementById('actividad').value = elementNombre;
        //         } else {
        //             if (elementNombre == document.getElementById('actividad').value) {
        //                 Swal.fire('El nombre ya ha sido vinculado', '', 'info');
        //             } else {
        //                 Swal.fire({
        //                     title: 'Atención',
        //                     text: "El campo de actividad actualmente contiene texto, ¿Desea sobreescribirlo?",
        //                     icon: 'warning',
        //                     showCancelButton: true,
        //                     confirmButtonColor: '#3085d6',
        //                     cancelButtonColor: '#d33',
        //                     confirmButtonText: 'Si',
        //                     cancelButtonText: 'No',
        //                 }).then((result) => {
        //                     if (result.isConfirmed) {
        //                         document.getElementById('actividad').value = elementNombre;
        //                     }
        //                 })
        //             }
        //         }
        //     } else {
        //         Swal.fire('No se ha descrito el nombre, no se puede vincular', '', 'info');
        //     }
        // })
    });

    function limpiarErrores() {
        document.querySelectorAll('.errores').forEach(element => {
            element.innerHTML = "";
        });
    }

    function limpiarCampos() {
        document.getElementById('actividad').value = '';
        document.getElementById('inicio').value = '';
        document.getElementById('finalizacion').value = '';
        document.getElementById('comentarios').value = '';
        $('.responsables_actividad').val(null).trigger('change');
    }

    function limpiarCampoPorId(id) {
        document.getElementById(id).value = '';
    }

    function agregarActividad() {
        let actividad = document.getElementById('actividad').value;
        let inicio = document.getElementById('inicio').value;
        let finalizacion = document.getElementById('finalizacion').value;
        let selectedValues = $('.responsables_actividad').select2('data');
        let comentarios = document.getElementById('comentarios').value;
        // let progreso = document.getElementById('progreso').value;
        let esFechaAnterior = Math.round((new Date(finalizacion).getTime() - new Date(inicio).getTime()) / (1000 *
            60 * 60 * 24)) < 0;
        if (actividad == '') {
            document.querySelector('.error_actividad').innerHTML = "El nombre de la actividad es requerido";
            limpiarCampoPorId('actividad');
        }
        if (inicio == '') {
            document.querySelector('.error_inicio').innerHTML = "El inicio de la actividad es requerido";
            limpiarCampoPorId('inicio');
        }
        if (finalizacion == '') {
            document.querySelector('.error_finalizacion').innerHTML = "La finalización de la actividad es requerido";
            limpiarCampoPorId('finalizacion');
        } else if (esFechaAnterior) {
            document.querySelector('.error_finalizacion').innerHTML =
                "La finalización de la actividad no puede ser días antes del día de inicio";
            limpiarCampoPorId('finalizacion');
        }
        if (selectedValues.length === 0) {
            document.querySelector('.error_participantes').innerHTML =
                "La actividad debe de tener al menos un participante";
            limpiarCampoPorId('responsables_actividad');
        }

        if (comentarios == '') {
            document.querySelector('.error_comentarios').innerHTML =
                "El los comentarios de la actividad son requeridos";
            limpiarCampoPorId('comentarios');
        }
        // if (progreso == '' || progreso < 0 || progreso > 100) {
        //     document.querySelector('.error_progreso').innerHTML =
        //         "El progreso de la actividad es requerido y debe estár en un rango de 0-100";
        //     limpiarCampoPorId('progreso');
        // }
        // && progreso != '' && progreso >= 0 && progreso <= 100 // Validaciones de progreso
        if (actividad != '' && inicio != '' && finalizacion != '' && !esFechaAnterior && comentarios != '' &&
            selectedValues.length > 0) {
            limpiarCampos();

            let actividades = tblActividades.rows().data().toArray();
            let arrActividades = [];
            actividades.forEach(actividad => {
                arrActividades.push(actividad[1]);
            });
            let name = actividad;
            // let start = new Date(inicio).getTime();
            // let end = new Date(finalizacion).getTime();
            let start = inicio;
            let end = finalizacion;
            let id = `tmp_${new Date().getTime()}_1`;
            let resta = new Date(end).getTime() - new Date(start).getTime();
            let duration = Math.round(resta / (1000 * 60 * 60 * 24));
            let images = "";
            let participantes_id = [];
            selectedValues.forEach(selected => {
                console.log(selected);
                images += `
                    <img class="rounded-circle" title="${selected.text.trim()}" src="{{ asset('storage/empleados/imagenes') }}/${selected.element.attributes.avatar.nodeValue}" id="res_${selected.id}" style="clip-path: circle(15px at 50% 50%);width: 45px;"/>
                `;
                participantes_id.push(selected.id);
            });

            // let progress = progreso;

            if (!arrActividades.includes(actividad)) {
                tblActividades.row.add([
                    id,
                    name,
                    start,
                    end,
                    duration,
                    images,
                    participantes_id,
                    comentarios,
                    `<button class="btn btn-sm text-danger" title="Eliminar actividad" onclick="event.preventDefault(); EliminarFila(this)"><i class="fa fa-trash-alt"></i></button>`,
                ]).draw();

            } else {
                Swal.fire('Esta actividad ya ha sido agregada', '', 'info');
                limpiarCampos();
            }
        }
    }
    window.EliminarFila = function(element) {
        tblActividades
            .row($(element).parents('tr'))
            .remove()
            .draw();
    }
    window.enviarActividades = function() {
        let actividades = tblActividades.rows().data().toArray();
        document.getElementById('actividades').value = JSON.stringify(actividades);
    }
</script>
