@extends('layouts.admin')
@section('content')
    <style>
        .select2-search.select2-search--inline {
            margin-top: -20px !important;
        }
    </style>

    {{ Breadcrumbs::render('admin.minutasaltadireccions.create') }}
    <h5 class="col-12 titulo_general_funcion">Registrar: Revisión por dirección</h5>
    <div class="mt-4 card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.minutasaltadireccions.store') }}" enctype="multipart/form-data"
                class="row">
                @csrf
                <div class="form-group col-sm-12 col-md-6 col-lg-6">
                    <label for="fechareunion"><i
                            class="fas fa-calendar-alt iconos-crear"></i>{{ trans('cruds.minutasaltadireccion.fields.fechareunion') }}<span
                            class="text-danger">*</span></label>
                    <input class="form-control date" type="date" name="fechareunion" id="fechareunion"
                        value="{{ old('fechareunion') }}">
                    @if ($errors->has('fechareunion'))
                        <span class="text-danger">
                            {{ $errors->first('fechareunion') }}
                        </span>
                    @endif
                    <span class="help-block">{{ trans('cruds.minutasaltadireccion.fields.fechareunion_helper') }}</span>
                </div>
                <div class="form-group col-sm-12 col-md-6 col-lg-6">
                    <label for="hora_inicio"><i class="fas fa-clock iconos-crear"></i>Horario de inicio<span
                            class="text-danger">*</span></label>
                    <input class="form-control date" type="time" name="hora_inicio" id="hora_inicio"
                        value="{{ old('hora_inicio') }}">
                    @if ($errors->has('hora_inicio'))
                        <span class="text-danger">
                            {{ $errors->first('hora_inicio') }}
                        </span>
                    @endif
                    <span class="help-block">{{ trans('cruds.minutasaltadireccion.fields.fechareunion_helper') }}</span>
                </div>
                <div class="form-group col-sm-12 col-md-6 col-lg-6">
                    <label for="responsable_id"><i class="fas fa-user-tie iconos-crear"></i>Elaboró</label>
                    <select class="form-control" name="responsable_id" id="responsable_id">
                        <option value="">Seleccione una opción</option>
                        @foreach ($responsablereunions as $responsablereunion)
                            <option value="{{ $responsablereunion->id }}"
                                {{ old('responsable_id') == $responsablereunion->id ? 'selected' : '' }}>
                                {{ $responsablereunion->name }}
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->has('responsablereunion'))
                        <span class="text-danger">
                            {{ $errors->first('responsablereunion') }}
                        </span>
                    @endif
                    <span
                        class="help-block">{{ trans('cruds.minutasaltadireccion.fields.responsablereunion_helper') }}</span>
                </div>
                <div class="form-group col-sm-12 col-md-6 col-lg-6">
                    <label for="hora_termino"><i class="fas fa-clock iconos-crear"></i>Horario de término<span
                            class="text-danger">*</span></label>
                    <input class="form-control date" type="time" name="hora_termino" id="hora_termino"
                        value="{{ old('hora_termino') }}">
                    @if ($errors->has('hora_termino'))
                        <span class="text-danger">
                            {{ $errors->first('hora_termino') }}
                        </span>
                    @endif
                </div>
                <div class="form-group col-sm-12 col-md-12 col-lg-12">
                    <label for="tema_reunion"><i class="fas fa-file-alt iconos-crear"></i>Tema de la reunión<span
                            class="text-danger">*</span></label>
                    <input data-vincular-nombre='true' class="form-control date" type="text" name="tema_reunion"
                        id="tema_reunion" value="{{ old('tema_reunion') }}">
                    @if ($errors->has('tema_reunion'))
                        <span class="text-danger">
                            {{ $errors->first('tema_reunion') }}
                        </span>
                    @endif
                </div>
                <div class="form-group col-sm-12 col-md-12 col-lg-12">
                    <label for="objetivoreunion"><i
                            class="fas fa-bullseye iconos-crear"></i>{{ trans('cruds.minutasaltadireccion.fields.objetivoreunion') }}<span
                            class="text-danger">*</span></label>
                    <textarea class="form-control" name="objetivoreunion" id="objetivoreunion">{{ old('objetivoreunion') }}</textarea>
                    @if ($errors->has('objetivoreunion'))
                        <span class="text-danger">
                            {{ $errors->first('objetivoreunion') }}
                        </span>
                    @endif
                    <span
                        class="help-block">{{ trans('cruds.minutasaltadireccion.fields.objetivoreunion_helper') }}</span>
                </div>
                <div class="mb-4 ml-4 w-100" style="border-bottom: solid 2px #345183;">
                    <span class="ml-1" style="font-size: 17px; font-weight: bold;">
                        Participantes</span>
                </div>
                <div class="pl-3 row w-100" x-data="muestra()">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-12" style="text-align: end">
                                <i class="fas fa-users bg-primary p-2 rounded text-white" ></i>
                                <i class="fas fa-user-tag" x-bind:class="externo ? 'bg-primary p-2 rounded text-white' : ''"
                                    style="color:black" @click.prevent="externo = !externo" title="Agregar externo"></i>
                            </div>
                        </div>
                        <div class="row" x-show="interno">
                            <div class="form-group col-sm-12 col-md-12 col-lg-6">
                                <label for="participantes"><i class="fas fa-search iconos-crear"></i>Buscar
                                    participante<span class="text-danger">*</span></label>
                                <input type="hidden" id="id_empleado">
                                <input class="form-control" type="text" id="participantes_search"
                                    placeholder="Busca un empleado" style="position: relative" autocomplete="off" />
                                <i id="cargando_participantes" class="fas fa-cog fa-spin text-muted"
                                    style="position: absolute; top: 43px; right: 25px;"></i>
                                <div id="participantes_sugeridos"></div>
                                @if ($errors->has('participantes'))
                                    <span class="text-danger">
                                        {{ $errors->first('participantes') }}
                                    </span>
                                @endif
                                <span class="help-block">{{ trans('cruds.recurso.fields.participantes_helper') }}</span>
                            </div>
                            <div class="form-group col-sm-12 col-md-12 col-lg-6">
                                <label for="email"><i class="fas fa-at iconos-crear"></i>Email</label>
                                <input class="form-control" type="text" id="email"
                                    placeholder="Correo del participante" readonly style="cursor: not-allowed" />
                            </div>
                            <div class="form-group col-sm-12 col-md-12 col-lg-6">
                                <label for="email"><i class="fas fa-suitcase iconos-crear"></i></i>Puesto</label>
                                <input class="form-control" type="text" id="puesto"
                                    placeholder="Puesto del participante" readonly style="cursor: not-allowed" />
                            </div>
                            <div class="form-group col-sm-12 col-md-12 col-lg-6">
                                <label for="area"><i class="fas fa-user-tag iconos-crear"></i></i>Área</label>
                                <input class="form-control" type="text" id="area"
                                    placeholder="Área del participante" readonly style="cursor: not-allowed" />
                            </div>
                            <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                <button id="btn-suscribir-participante" type="submit"
                                    class="mr-3 btn btn-sm btn-outline-success" style="float: right; position: relative;">
                                    <i class="mr-1 fas fa-plus-circle"></i>
                                    Agregar Participante
                                </button>
                            </div>
                            <div class="mt-3 col-12 w-100 datatable-fix">
                                <table class="table w-100" id="tbl-participantes">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Puesto</th>
                                            {{-- <th scope="col">Área</th> --}}
                                            <th>Correo</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                            <input type="hidden" name="participantes" value="" id="participantes">
                        </div>
                        <div class="row" x-show="externo">
                            <p class="font-weight-bold col-12" style="font-size:11pt;">Participantes externos.</p>
                            <hr>
                            <div class="form-group col-sm-12 col-md-12 col-lg-6">
                                <label for="nombreEXT"><i class="fas fa-at iconos-crear"></i>Nombre</label>
                                <input class="form-control" type="text" id="nombreEXT"
                                    placeholder="Nombre del participante" />
                            </div>
                            <div class="form-group col-sm-12 col-md-12 col-lg-6">
                                <label for="emailEXT"><i class="fas fa-at iconos-crear"></i>Email</label>
                                <input class="form-control" type="text" id="emailEXT"
                                    placeholder="Correo del participante" />
                            </div>
                            <div class="form-group col-sm-12 col-md-12 col-lg-6">
                                <label for="puestoEXT"><i class="fas fa-suitcase iconos-crear"></i></i>Puesto</label>
                                <input class="form-control" type="text" id="puestoEXT"
                                    placeholder="Puesto del participante" />
                            </div>
                            <div class="form-group col-sm-12 col-md-12 col-lg-6">
                                <label for="empresaEXT"><i class="fas fa-user-tag iconos-crear"></i></i>Empresa u
                                    Organización</label>
                                <input class="form-control" type="text" id="empresaEXT"
                                    placeholder="Empresa u Organización del participante" />
                            </div>
                            <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                <button id="btn-suscribir-participanteEXT" onclick="event.preventDefault();"
                                    class="mr-3 btn btn-sm btn-outline-success" style="float: right; position: end;">
                                    <i title="Agregar Participantes Externos" class="mr-1 fas fa-plus-circle"></i>
                                    Agregar Participante
                                </button>
                            </div>
                            <div class="mt-3 col-12 w-100 datatable-fix">
                                <table class="table w-100" id="tbl-participantesEXT">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Correo</th>
                                            <th>Puesto</th>
                                            <th>Empresa u Organización</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                                <input type="hidden" name="participantesExt" value="" id="participantesExt">
                            </div>

                        </div>
                    </div>
                </div>


                <div class="form-group col-sm-12 col-md-12 col-lg-12 mt-4">
                    <label for="tema_tratado"><i class="fas fa-file-alt iconos-crear"></i>Temas tratados<span
                            class="text-danger">*</span></label>
                    <textarea class="form-control date" type="text" name="tema_tratado" id="temas">
                                        {{ old('tema_tratado') }}
                                    </textarea>
                    @if ($errors->has('tema_tratado'))
                        <span class="text-danger">
                            {{ $errors->first('tema_tratado') }}
                        </span>
                    @endif
                </div>

                <div class="mb-4 col-sm-12 form-group">
                    <label for="evidencia"><i class="fas fa-folder-open iconos-crear"></i>Documento</label>
                    <div class="custom-file">
                        <input type="file" name="files[]" multiple class="form-control" id="files"
                            accept="image/*,.pdf">
                    </div>
                </div>


                {{-- <form></form>


                <form action="{{ route('admin.minutasaltadireccions.store') }}" method="POST" class="dropzone"
                    id="my-awesome-dropzone">
                </form> --}}


                {{-- MODULO AGREGAR PLAN DE ACCIÓN --}}
                @include('admin.planesDeAccion.actividades.tabla', [
                    'empleados' => $responsablereunions,
                ])
                {{-- FIN MODULO AGREGAR PLAN DE ACCIÓN --}}


                <div class="text-right form-group col-12">
                    <a href="{{ redirect()->getUrlGenerator()->previous() }}" class="btn_cancelar">Cancelar</a>
                    <button class="btn btn-danger" id="btnGuardar" type="submit">
                        {{ trans('global.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Button trigger modal -->

    <!-- Modal -->
    <div class="modal fade" id="alertaVinculacion" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="alertaVinculacionLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="alertaVinculacionLabel">Alerta de Vinculación</h5>
                    {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button> --}}
                </div>
                <div class="modal-body">
                    El usuario no esta vinculado a un empleado

                </div>
                <div class="modal-footer">
                    <a type="button" href="{{ route('admin.users.index') }}" class="btn btn-primary">Vincular</a>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script>
        $(document).ready(function() {
            CKEDITOR.replace('temas', {
                toolbar: [{
                        name: 'styles',
                        items: ['Styles', 'Format', 'Font', 'FontSize']
                    },
                    {
                        name: 'colors',
                        items: ['TextColor', 'BGColor']
                    },
                    {
                        name: 'editing',
                        groups: ['find', 'selection', 'spellchecker'],
                        items: ['Find', 'Replace', '-', 'SelectAll', '-', 'Scayt']
                    }, {
                        name: 'clipboard',
                        groups: ['undo'],
                        items: ['Undo', 'Redo']
                    },
                    {
                        name: 'tools',
                        items: ['Maximize']
                    },
                    {
                        name: 'basicstyles',
                        groups: ['basicstyles', 'cleanup'],
                        items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript',
                            '-',
                            'CopyFormatting', 'RemoveFormat'
                        ]
                    },
                    {
                        name: 'paragraph',
                        groups: ['list', 'indent', 'blocks', 'align', 'bidi'],
                        items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-',
                            'Blockquote',
                            '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight',
                            'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language'
                        ]
                    },
                    {
                        name: 'links',
                        items: ['Link', 'Unlink']
                    },
                    {
                        name: 'insert',
                        items: ['Table', 'HorizontalRule', 'Smiley', 'SpecialChar']
                    },
                    '/',
                ]
            });

        });
    </script>

    <script type="text/javascript">
        Livewire.on('planStore', () => {
            $('#planAccionModal').modal('hide');
            $('.modal-backdrop').hide();
            toastr.success('Plan de Acción creado con éxito');
        });
        window.initSelect2 = () => {
            $('.select2').select2({
                'theme': 'bootstrap4'
            });
        }

        initSelect2();

        Livewire.on('select2', () => {
            initSelect2();
        });
    </script>

    <script>
        $(document).ready(function() {
            if (!@json($esta_vinculado)) {
                $('#alertaVinculacion').modal('show')
            }
            window.tblParticipantes = $('#tbl-participantes').DataTable({
                buttons: []
            })
            window.tblParticipantesEXT = $('#tbl-participantesEXT').DataTable({
                buttons: []
            })

            $("#cargando_participantes").hide();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let url = "{{ route('admin.empleados.get') }}";
            $("#participantes_search").keyup(function() {
                $.ajax({
                    type: "POST",
                    url: url,
                    data: 'nombre=' + $(this).val(),
                    beforeSend: function() {
                        $("#cargando_participantes").show();
                    },
                    success: function(data) {
                        let lista = "<ul class='list-group id=empleados-lista' >";
                        $.each(data.usuarios, function(ind, usuario) {
                            var result = `{"id":"${usuario.id}",
                                "name":"${usuario.name}",
                                "email":"${usuario.email}",
                                "puesto":"${usuario.puesto}",
                                "area":"${usuario.area.area}"
                                }`;
                            lista +=
                                "<button type='button' class='px-2 py-1 text-muted list-group-item list-group-item-action' onClick='seleccionarUsuario(" +
                                result + ")' ><i class='mr-2 fas fa-user-circle'></i>" +
                                usuario.name + "</button>";
                        });
                        lista += "</ul>";

                        $("#cargando_participantes").hide();
                        $("#participantes_sugeridos").show();
                        let sugeridos = document.querySelector("#participantes_sugeridos");
                        sugeridos.innerHTML = lista;
                        $("#participantes_search").css("background", "#FFF");
                    }
                });

            });

            document.getElementById('btn-suscribir-participante').addEventListener('click', function(e) {
                e.preventDefault();
                suscribirParticipante()
            })
            document.getElementById('btn-suscribir-participanteEXT').addEventListener('click', function(e) {
                e.preventDefault();
                suscribirParticipanteExterno()
            })

            document.getElementById('btnGuardar').addEventListener('click', function(e) {
                // e.preventDefault();
                enviarParticipantes();
                enviarParticipantesExternos();
                enviarActividades();
            })

            document.getElementById('btnUpdateAndReview').addEventListener('click', function(e) {
                // e.preventDefault();
                enviarParticipantes();
                enviarParticipantesExternos();
                enviarActividades();
            })

        });

        function seleccionarUsuario(user) {
            $("#participantes_search").val(user.name);
            $("#id_empleado").val(user.id);
            $("#email").val(user.email);
            $("#puesto").val(user.puesto);
            $("#area").val(user.area);
            $("#participantes_sugeridos").hide();
        }


        function suscribirParticipante() {
            //form-participantes

            let participantes = tblParticipantes.rows().data().toArray();
            // console.log(tblParticipantes.rows().data().toArray());
            let arrParticipantes = [];
            participantes.forEach(participante => {
                arrParticipantes.push(participante[0])
            });
            let id_empleado = $("#id_empleado").val();
            if (id_empleado == '') {
                Swal.fire('Debes de buscar un empleado', '', 'info')
            } else {
                if (!arrParticipantes.includes(id_empleado)) {
                    let nombre = $("#participantes_search").val();
                    let puesto = $("#puesto").val();
                    let email = $("#email").val();
                    let area = $("#area").val();
                    tblParticipantes.row.add([
                        id_empleado,
                        nombre,
                        puesto,
                        email,
                        area,
                    ]).draw();

                } else {
                    Swal.fire('Este participante ya ha sido agregado', '', 'error')
                }

                $("#participantes_search").val('');
                $("#id_empleado").val('');
                $("#email").val('');
                $("#puesto").val('');
                $("#area").val('');
            }
        }

        function enviarParticipantes() {
            let participantes = tblParticipantes.rows().data().toArray();
            let arrParticipantes = [];
            participantes.forEach(participante => {
                arrParticipantes.push(participante[0])

            });
            document.getElementById('participantes').value = arrParticipantes;
        }

        function suscribirParticipanteExterno() {
            //form-participantes
            let email = $("#emailEXT").val();
            let nombre = $("#nombreEXT").val();
            if (email != '' && nombre != '') {

                let participantes = tblParticipantesEXT.rows().data().toArray();
                // console.log(tblParticipantes.rows().data().toArray());
                let arrParticipantes = [];
                participantes.forEach(participante => {
                    console.log(participante);
                    arrParticipantes.push(participante[1])
                });
                if (!arrParticipantes.includes(email)) {
                    let puesto = $("#puestoEXT").val();
                    let empresa = $("#empresaEXT").val();
                    tblParticipantesEXT.row.add([
                        nombre,
                        email,
                        puesto,
                        empresa,
                    ]).draw();

                } else {
                    Swal.fire('Este participante ya ha sido agregado', '', 'error')
                }

                $("#participantes_search").val('');
                $("#nombreEXT").val('');
                $("#puestoEXT").val('');
                $("#emailEXT").val('');
                $("#empresaEXT").val('');
            } else {
                Swal.fire('Debes de llenar los campos nombre e email', '', 'info')
            }

        }

        function enviarParticipantesExternos() {
            let participantes = tblParticipantesEXT.rows().data().toArray();
            let arrParticipantes = [];
            participantes.forEach(participante => {
                let objParticipantes = {
                    nombre: participante[0],
                    email: participante[1],
                    puesto: participante[2],
                    empresa: participante[3],
                }
                arrParticipantes.push(objParticipantes)
            });
            console.log(arrParticipantes);
            document.getElementById('participantesExt').value = JSON.stringify(arrParticipantes);
        }


        function muestra() {

            return {
                interno: true,
                externo: false,
            }
        }
    </script>
@endsection
