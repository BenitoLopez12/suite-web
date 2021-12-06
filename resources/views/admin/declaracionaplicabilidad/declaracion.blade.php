<div class="px-1 py-2 mx-3 rounded shadow" style="background-color: #DBEAFE; border-top:solid 3px #3B82F6;">
    <div class="row w-100">
        <div class="text-center col-1 align-items-center d-flex justify-content-center">
            <div class="w-100">
                <i class="fas fa-info-circle" style="color: #3B82F6; font-size: 22px"></i>
            </div>
        </div>
        <div class="col-11">
            <p class="m-0" style="font-size: 16px; font-weight: bold; color: #1E3A8A">Intrucciones</p>
            <p class="m-0" style="font-size: 14px; color:#1E3A8A ">Por favor seleccione de los siguientes controles
                cuales serán aplicables a su organización y justifique su selección
            </p>

        </div>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="card-body">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="mb-2 col">
                            @can('declaracion_aplicabilidad_reporte')
                                <button url="{{ route('admin.declaracion-aplicabilidad.descargar') }}"
                                    onclik="generarReporte()" class="btn btn-sm btn-outline-primary generar-reporte">
                                    <i class="mr-1 fas fa-print"></i>
                                    Generar Reporte
                                </button>
                            @endcan
                            @if (count($lista_archivos_declaracion) > 0)
                                <div class="btn-group dropright">
                                    <button type="button" class="btn btn-sm btn-outline-danger dropdown-toggle"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="far fa-file-pdf"></i>
                                        Documentos Generados
                                    </button>
                                    <div class="dropdown-menu">
                                        @foreach ($lista_archivos_declaracion as $archivo)
                                            <a class="dropdown-item" target="_blank"
                                                href=" {{ asset($ISO27001_SoA_PATH . basename($archivo)) }}">
                                                <i class="far fa-file-pdf text-danger"></i>
                                                {{ basename($archivo) }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            <button type="button" class="btn btn-sm btn-outline-success dropdown-toggle"
                             aria-haspopup="true" aria-expanded="false" data-toggle="modal" data-target="#ResponsablesModal">
                             <i class="far fa-file"></i>
                            Notificar responsable
                        </button>
                            {{-- <a href="#" class="btn btn-sm btn-primary tamaño" style="with:400px !important;" data-toggle="modal" data-target="#ResponsablesModal">Notificar&nbsp;responsable</a> --}}
                        </div>




                        <div class="table-responsive">
                            <table class="table" style="font-size: 12px;">
                                <thead class="thead-dark" align="center">
                                    <tr>
                                        <th scope="col" style="width: 5%">INDICE</th>
                                        <th style="min-width:400px" COLSPAN="2">CONTROL</th>
                                        <th style="width:15px !important;" >RESPONSABLE</th>
                                        <th scope="col" style="width: 5%">APLICA</th>
                                        <th style="min-width:200px;" scope="col">JUSTIFICACIÓN</th>
                                        <th style="width:15%;" scope="col">ESTATUS</th>
                                        <th style="width:35%;" scope="col">COMENTARIOS</th>
                                        <th style="width:15px !important;" >APROBADOR</th>
                                        <th style="width:15px !important;" >FECHA DE APROBACIÓN</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr class="negras">
                                        <td class="p-2 mb-2 text-white bg-info" style="font-size: 12px;" colspan="10">A.5
                                            Políticas de Seguridad de Información</td>
                                    </tr>
                                    <tr class="verdes">
                                        <td class="p-2 mb-2 text-white bg-info" style="font-size: 12px;" colspan="10">
                                            A.5.1 Directivas de la gestión para seguridad de la
                                            información</td>
                                    </tr>
                                    @foreach ($gapda5s as $g5s)
                                        <tr>

                                            <th scope="row" style="width: 5%">
                                                {{ $g5s->anexo_indice }}
                                            </th>
                                            <td style="width:20%">
                                                {{ $g5s->anexo_politica }}
                                            </td>
                                            <td style="width:35%">
                                                {{ $g5s->anexo_descripcion }}
                                            </td>
                                            <td>
                                                {{$g5s->empleado_id}}
                                             </td>
                                            <td style="width:5%">
                                                <a href="#" data-type="select" data-pk="{{ $g5s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g5s->id) }}"
                                                    data-title="Seleccionar aplica" data-value="{{ $g5s->aplica }}"
                                                    class="aplica2" data-name="aplica">
                                                </a>
                                            </td>
                                            <td class="text-justify">
                                                <a data-type="textarea" data-pk="{{ $g5s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g5s->id) }}"
                                                    data-title="Justificacion" data-value="{{ $g5s->justificacion }}"
                                                    class="justificacion" data-name="justificacion">
                                                </a>
                                            </td>
                                            <td style="width:15%">
                                                <a href="#" data-type="select" data-pk="{{ $g5s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g5s->id) }}"
                                                    data-title="Seleccionar estatus" data-value="{{ $g5s->estatus }}"
                                                    class="estatus" data-name="estatus" onchange='cambioOpciones();' id="opciones">
                                                </a>
                                            </td>
                                            <td>
                                                <a href="#" data-type="textarea" data-pk="{{ $g5s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g5s->id) }}"
                                                    data-title="Comentarios" data-value="{{ $g5s->comentarios }}"
                                                    class="justificacion" data-name="comentarios" >
                                                </a>
                                            </td>
                                            <td>
                                               {{$g5s->aprobadores_id}}
                                            </td>
                                            <td style="width:15%" id="actualizacion_fecha_{{$g5s->id}}" >
                                                @if($g5s->estatus == 2 )
                                                {{$g5s->updated_at}}
                                                @endif
                                                hola

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive">


                            <table class="table" style="font-size: 12px;">
                                <thead class="thead-dark" align="center">
                                    <tr>
                                        <th scope="col" style="width: 5%">INDICE</th>
                                        <th style="min-width:400px" COLSPAN="2">CONTROL</th>
                                        <th scope="col" style="width: 5%">APLICA</th>
                                        <th style="min-width:200px;" scope="col">JUSTIFICACIÓN</th>
                                        <th style="width:15%;" scope="col">ESTATUS</th>
                                        <th style="width:35%;" scope="col">COMENTARIOS</th>
                                        <th style="width:15px !important;" >APROBADOR</th>
                                        <th style="width:15px !important;" >FECHA DE APROBACIÓN</th>

                                    </tr>
                                </thead>
                                <tbody>

                                    <tr class="negras">
                                        <td class="p-2 mb-2 text-white bg-info" style="font-size: 12px;" colspan="10">A.6
                                            Organización de la seguridad de la información</td>
                                    </tr>
                                    <tr class="verdes">
                                        <td class="p-2 mb-2 text-white bg-info" style="font-size: 12px;" colspan="10">
                                            A.6.1 organización interna</td>
                                    </tr>

                                    @foreach ($gapda6s as $g6s)
                                        <tr>
                                            <th scope="row" style="width: 5%">
                                                {{ $g6s->anexo_indice }}
                                            </th>
                                            <td style="width:20%">
                                                {{ $g6s->anexo_politica }}
                                            </td>
                                            <td style="width:35%">
                                                {{ $g6s->anexo_descripcion }}
                                            </td>
                                            <td style="width:5%">
                                                <a href="#" data-type="select" data-pk="{{ $g6s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g6s->id) }}"
                                                    data-title="Seleccionar aplica" data-value="{{ $g6s->aplica }}"
                                                    class="aplica2" data-name="aplica">
                                                </a>
                                            </td>

                                            <td class="text-justify">
                                                <a href="#" data-type="textarea" data-pk="{{ $g6s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g6s->id) }}"
                                                    data-title="Justificacion" data-value="{{ $g6s->justificacion }}"
                                                    class="justificacion" data-name="justificacion">
                                                </a>
                                            </td>
                                            <td style="width:15%">
                                                <a href="#" data-type="select" data-pk="{{ $g6s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g6s->id) }}"
                                                    data-title="Seleccionar estatus" data-value="{{ $g6s->estatus }}"
                                                    class="estatus" data-name="estatus" onchange='cambioOpciones();' id="opciones">
                                                </a>
                                            </td>
                                            <td>
                                                <a href="#" data-type="textarea" data-pk="{{ $g6s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g6s->id) }}"
                                                    data-title="Comentarios" data-value="{{ $g6s->comentarios }}"
                                                    class="comentarios" data-name="comentarios" >
                                                </a>
                                            </td>
                                            <td>
                                                Hola
                                            </td>
                                            <td style="width:15%" id="actualizacion_fecha_{{$g6s->id}}" >
                                                @if($g6s->estatus == 2 )
                                                {{$g6s->updated_at}}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <table class="table" style="font-size: 12px;">
                            <thead class="thead-dark" align="center">
                                <tr>
                                    <th scope="col" style="width: 5%">INDICE</th>
                                    <th style="min-width:400px" COLSPAN="2">CONTROL</th>
                                    <th scope="col" style="width: 5%">APLICA</th>
                                    <th style="min-width:200px;" scope="col">JUSTIFICACIÓN</th>
                                    <th style="width:15%;" scope="col">ESTATUS</th>
                                    <th style="width:35%;" scope="col">COMENTARIOS</th>
                                    <th style="width:15px !important;" >APROBADOR</th>
                                    <th style="width:15px !important;" >FECHA DE APROBACIÓN</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($gapda62s as $g62s)
                                    <tr>
                                        <th scope="row" style="width: 5%">
                                            {{ $g62s->anexo_indice }}
                                        </th>
                                        <td style="width:20%">
                                            {{ $g62s->anexo_politica }}
                                        </td>
                                        <td style="width:35%">
                                            {{ $g62s->anexo_descripcion }}
                                        </td>
                                        <td style="width:5%">
                                            <a href="#" data-type="select" data-pk="{{ $g62s->id }}"
                                                data-url="{{ route('admin.declaracion-aplicabilidad.update', $g62s->id) }}"
                                                data-title="Seleccionar aplica" data-value="{{ $g62s->aplica }}"
                                                class="aplica2" data-name="aplica">
                                            </a>
                                        </td>
                                        <td class="text-justify">
                                            <a href="#" data-type="textarea" data-pk="{{ $g62s->id }}"
                                                data-url="{{ route('admin.declaracion-aplicabilidad.update', $g62s->id) }}"
                                                data-title="Justificacion" data-value="{{ $g62s->justificacion }}"
                                                class="justificacion" data-name="justificacion">
                                            </a>
                                        </td>
                                        <td style="width:15%">
                                            <a href="#" data-type="select" data-pk="{{ $g62s->id }}"
                                                data-url="{{ route('admin.declaracion-aplicabilidad.update', $g62s->id) }}"
                                                data-title="Seleccionar estatus" data-value="{{ $g62s->estatus }}"
                                                class="estatus" data-name="estatus" onchange='cambioOpciones();' id="opciones">
                                            </a>
                                        </td>
                                        <td>
                                            <a href="#" data-type="textarea" data-pk="{{ $g62s->id }}"
                                                data-url="{{ route('admin.declaracion-aplicabilidad.update', $g62s->id) }}"
                                                data-title="Comentarios" data-value="{{ $g62s->comentarios }}"
                                                class="comentarios" data-name="comentarios" >
                                            </a>
                                        </td>
                                        <td>
                                            Hola
                                        </td>
                                        <td style="width:15%" id="actualizacion_fecha_{{$g62s->id}}" >
                                            @if($g62s->estatus == 2 )
                                            {{$g62s->updated_at}}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="table-responsive">

                            <table class="table" style="font-size: 12px;">
                                <thead class="thead-dark" align="center">
                                    <tr>
                                        <th scope="col" style="width: 5%">INDICE</th>
                                        <th style="min-width:400px" COLSPAN="2">CONTROL</th>
                                        <th scope="col" style="width: 5%">APLICA</th>
                                        <th style="min-width:200px;" scope="col">JUSTIFICACIÓN</th>
                                        <th style="width:15%;" scope="col">ESTATUS</th>
                                        <th style="width:35%;" scope="col">COMENTARIOS</th>
                                        <th style="width:15px !important;" >APROBADOR</th>
                                        <th style="width:15px !important;" >FECHA DE APROBACIÓN</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr class="negras">
                                        <td class="p-2 mb-2 text-white bg-info" style="font-size: 12px;" colspan="10">A.7
                                            seguridad de los recursos humanos</td>
                                    </tr>
                                    <tr class="verdes">
                                        <td class="p-2 mb-2 text-white bg-info" style="font-size: 12px;" colspan="10">
                                            A.7.1 Antes de empleo</td>
                                    </tr>


                                    @foreach ($gapda71s as $g71s)
                                        <tr>
                                            <th scope="row" style="width: 5%">
                                                {{ $g71s->anexo_indice }}
                                            </th>
                                            <td style="width:20%">
                                                {{ $g71s->anexo_politica }}
                                            </td>
                                            <td style="width:35%">
                                                {{ $g71s->anexo_descripcion }}
                                            </td>
                                            <td style="width:5%">
                                                <a href="#" data-type="select" data-pk="{{ $g71s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g71s->id) }}"
                                                    data-title="Seleccionar aplica" data-value="{{ $g71s->aplica }}"
                                                    class="aplica2" data-name="aplica">
                                                </a>
                                            </td>
                                            <td class="text-justify">
                                                <a href="#" data-type="textarea" data-pk="{{ $g71s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g71s->id) }}"
                                                    data-title="Justificacion"
                                                    data-value="{{ $g71s->justificacion }}" class="justificacion"
                                                    data-name="justificacion">
                                                </a>
                                            </td>
                                            <td style="width:15%">
                                                <a href="#" data-type="select" data-pk="{{ $g71s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g71s->id) }}"
                                                    data-title="Seleccionar estatus" data-value="{{$g71s->estatus }}"
                                                    class="estatus" data-name="estatus" onchange='cambioOpciones();' id="opciones">
                                                </a>
                                            </td>
                                            <td>
                                                <a href="#" data-type="textarea" data-pk="{{ $g71s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g71s->id) }}"
                                                    data-title="Comentarios" data-value="{{ $g71s->comentarios }}"
                                                    class="comentarios" data-name="comentarios" >
                                                </a>
                                            </td>
                                            <td>
                                                Hola
                                            </td>
                                            <td style="width:15%" id="actualizacion_fecha_{{$g71s->id}}" >
                                                @if($g5s->estatus == 2 )
                                                {{$g5s->updated_at}}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="table-responsive">

                            <table class="table" style="font-size: 12px;">
                                <thead class="thead-dark" align="center">
                                    <tr>
                                        <th scope="col" style="width: 5%">INDICE</th>
                                        <th style="min-width:400px" COLSPAN="2">CONTROL</th>
                                        <th scope="col" style="width: 5%">APLICA</th>
                                        <th style="min-width:200px;" scope="col">JUSTIFICACIÓN</th>
                                        <th style="width:15%;" scope="col">ESTATUS</th>
                                        <th style="width:35%;" scope="col">COMENTARIOS</th>
                                        <th style="width:15px !important;" >APROBADOR</th>
                                        <th style="width:15px !important;" >FECHA DE APROBACIÓN</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr class="verdes">
                                        <td class="p-2 mb-2 text-white bg-info" style="font-size: 12px;" colspan="10">A
                                            7.2 Durante el empleo</td>
                                    </tr>
                                    @foreach ($gapda72s as $g72s)
                                        <tr>
                                            <th scope="row" style="width: 5%">
                                                {{ $g72s->anexo_indice }}
                                            </th>
                                            <td style="width:20%">
                                                {{ $g72s->anexo_politica }}
                                            </td>
                                            <td style="width:35%">
                                                {{ $g72s->anexo_descripcion }}
                                            </td>
                                            <td style="width:5%">
                                                <a href="#" data-type="select" data-pk="{{ $g72s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g72s->id) }}"
                                                    data-title="Seleccionar aplica" data-value="{{ $g72s->aplica }}"
                                                    class="aplica2" data-name="aplica">
                                                </a>
                                            </td>

                                            <td class="text-justify">
                                                <a href="#" data-type="textarea" data-pk="{{ $g72s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g72s->id) }}"
                                                    data-title="Justificacion"
                                                    data-value="{{ $g72s->justificacion }}" class="justificacion"
                                                    data-name="justificacion">
                                                </a>
                                            </td>
                                            <td style="width:15%">
                                                <a href="#" data-type="select" data-pk="{{ $g72s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g72s->id) }}"
                                                    data-title="Seleccionar estatus" data-value="{{$g72s->estatus }}"
                                                    class="estatus" data-name="estatus" onchange='cambioOpciones();' id="opciones">
                                                </a>
                                            </td>
                                            <td>
                                                <a href="#" data-type="textarea" data-pk="{{ $g72s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g72s->id) }}"
                                                    data-title="Comentarios" data-value="{{ $g72s->comentarios }}"
                                                    class="comentarios" data-name="comentarios" >
                                                </a>
                                            </td>
                                            <td>
                                                Hola
                                            </td>
                                            <td style="width:15%" id="actualizacion_fecha_{{$g72s->id}}" >
                                                @if($g5s->estatus == 2 )
                                                {{$g5s->updated_at}}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive">

                            <table class="table" style="font-size: 12px;">
                                <thead class="thead-dark" align="center">
                                    <tr>
                                        <th scope="col" style="width: 5%">INDICE</th>
                                        <th style="min-width:400px" COLSPAN="2">CONTROL</th>
                                        <th scope="col" style="width: 5%">APLICA</th>
                                        <th style="min-width:200px;" scope="col">JUSTIFICACIÓN</th>
                                        <th style="width:15%;" scope="col">ESTATUS</th>
                                        <th style="width:35%;" scope="col">COMENTARIOS</th>
                                        <th style="width:15px !important;" >APROBADOR</th>
                                        <th style="width:15px !important;" >FECHA DE APROBACIÓN</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr class="verdes">
                                        <td class="p-2 mb-2 text-white bg-info" style="font-size: 12px;" colspan="10">
                                            A.7.3 Cese al empleo o cambio de puesto de trabajo</td>
                                    </tr>
                                    @foreach ($gapda73s as $g73s)
                                        <tr>
                                            <th scope="row" style="width: 5%">
                                                {{ $g73s->anexo_indice }}
                                            </th>
                                            <td style="width:20%">
                                                {{ $g73s->anexo_politica }}
                                            </td>
                                            <td style="width:35%">
                                                {{ $g73s->anexo_descripcion }}
                                            </td>
                                            <td style="width:5%">
                                                <a href="#" data-type="select" data-pk="{{ $g73s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g73s->id) }}"
                                                    data-title="Seleccionar aplica" data-value="{{ $g73s->aplica }}"
                                                    class="aplica2" data-name="aplica">
                                                </a>
                                            </td>

                                            <td class="text-justify">
                                                <a href="#" data-type="textarea" data-pk="{{ $g73s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g73s->id) }}"
                                                    data-title="Justificacion"
                                                    data-value="{{ $g73s->justificacion }}" class="justificacion"
                                                    data-name="justificacion">
                                                </a>
                                            </td>
                                            <td style="width:15%">
                                                <a href="#" data-type="select" data-pk="{{$g73s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update',$g73s->id) }}"
                                                    data-title="Seleccionar estatus" data-value="{{$g73s->estatus }}"
                                                    class="estatus" data-name="estatus" onchange='cambioOpciones();' id="opciones">
                                                </a>
                                            </td>
                                            <td>
                                                <a href="#" data-type="textarea" data-pk="{{$g73s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update',$g73s->id) }}"
                                                    data-title="Comentarios" data-value="{{$g73s->comentarios }}"
                                                    class="comentarios" data-name="comentarios" >
                                                </a>
                                            </td>
                                            <td>
                                                Hola
                                            </td>
                                            <td style="width:15%" id="actualizacion_fecha_{{$g73s->id}}" >
                                                @if($g73s->estatus == 2 )
                                                {{$g73s->updated_at}}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive">

                            <table class="table" style="font-size: 12px;">
                                <thead class="thead-dark" align="center">
                                    <tr>
                                        <th scope="col" style="width: 5%">INDICE</th>
                                        <th style="min-width:400px" COLSPAN="2">CONTROL</th>
                                        <th scope="col" style="width: 5%">APLICA</th>
                                        <th style="min-width:200px;" scope="col">JUSTIFICACIÓN</th>
                                        <th style="width:15%;" scope="col">ESTATUS</th>
                                        <th style="width:35%;" scope="col">COMENTARIOS</th>
                                        <th style="width:15px !important;" >APROBADOR</th>
                                        <th style="width:15px !important;" >FECHA DE APROBACIÓN</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr class="negras">
                                        <td class="p-2 mb-2 text-white bg-info" style="font-size: 12px;" colspan="10">A.8
                                            Administración de activos</td>
                                    </tr>
                                    <tr class="verdes">
                                        <td class="p-2 mb-2 text-white bg-info" style="font-size: 12px;" colspan="10">
                                            A.8.1 Responsabilidad sobre los activos</td>
                                    </tr>

                                    @foreach ($gapda81s as $g81s)
                                        <tr>
                                            <th scope="row" style="width: 5%">
                                                {{ $g81s->anexo_indice }}
                                            </th>
                                            <td style="width:20%">
                                                {{ $g81s->anexo_politica }}
                                            </td>
                                            <td style="width:35%">
                                                {{ $g81s->anexo_descripcion }}
                                            </td>
                                            <td style="width:5%">
                                                <a href="#" data-type="select" data-pk="{{ $g81s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g81s->id) }}"
                                                    data-title="Seleccionar aplica" data-value="{{ $g81s->aplica }}"
                                                    class="aplica2" data-name="aplica">
                                                </a>
                                            </td>

                                            <td class="text-justify">
                                                <a href="#" data-type="textarea" data-pk="{{ $g81s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g81s->id) }}"
                                                    data-title="Justificacion"
                                                    data-value="{{ $g81s->justificacion }}" class="justificacion"
                                                    data-name="justificacion">
                                                </a>
                                            </td>
                                            <td style="width:15%">
                                                <a href="#" data-type="select" data-pk="{{ $g81s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g81s->id) }}"
                                                    data-title="Seleccionar estatus" data-value="{{$g81s->estatus }}"
                                                    class="estatus" data-name="estatus" onchange='cambioOpciones();' id="opciones">
                                                </a>
                                            </td>
                                            <td>
                                                <a href="#" data-type="textarea" data-pk="{{ $g81s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g81s->id) }}"
                                                    data-title="Comentarios" data-value="{{ $g81s->comentarios }}"
                                                    class="comentarios" data-name="comentarios" >
                                                </a>
                                            </td>
                                            <td>
                                                Hola
                                            </td>
                                            <td style="width:15%" id="actualizacion_fecha_{{$g81s->id}}" >
                                                @if($g81s->estatus == 2 )
                                                {{$g81s->updated_at}}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive">

                            <table class="table" style="font-size: 12px;">
                                <thead class="thead-dark" align="center">
                                    <tr>
                                        <th scope="col" style="width: 5%">INDICE</th>
                                        <th style="min-width:400px" COLSPAN="2">CONTROL</th>
                                        <th scope="col" style="width: 5%">APLICA</th>
                                        <th style="min-width:200px;" scope="col">JUSTIFICACIÓN</th>
                                        <th style="width:15%;" scope="col">ESTATUS</th>
                                        <th style="width:35%;" scope="col">COMENTARIOS</th>
                                        <th style="width:15px !important;" >APROBADOR</th>
                                        <th style="width:15px !important;" >FECHA DE APROBACIÓN</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr class="verdes">
                                        <td class="p-2 mb-2 text-white bg-info" style="font-size: 12px;" colspan="10">
                                            A.8.2 Clasificación de la información</td>
                                    </tr>
                                    <tr class="grises">
                                        <td class="p-2 mb-2 text-white bg-info" style="font-size: 12px;" colspan="10">
                                            Objetivo de control: Asegurar que la información reciba un
                                            nivel adecuado de protección, de acuerdo con su importancia para la
                                            organización.</td>
                                    </tr>
                                    @foreach ($gapda82s as $g82s)
                                        <tr>
                                            <th scope="row" style="width: 5%">
                                                {{ $g82s->anexo_indice }}
                                            </th>
                                            <td style="width:20%">
                                                {{ $g82s->anexo_politica }}
                                            </td>
                                            <td style="width:35%">
                                                {{ $g82s->anexo_descripcion }}
                                            </td>
                                            <td style="width:5%">
                                                <a href="#" data-type="select" data-pk="{{ $g82s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g82s->id) }}"
                                                    data-title="Seleccionar aplica" data-value="{{ $g82s->aplica }}"
                                                    class="aplica2" data-name="aplica">
                                                </a>
                                            </td>

                                            <td class="text-justify">
                                                <a href="#" data-type="textarea" data-pk="{{ $g82s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g82s->id) }}"
                                                    data-title="Justificacion"
                                                    data-value="{{ $g82s->justificacion }}" class="justificacion"
                                                    data-name="justificacion">
                                                </a>
                                            </td>
                                            <td style="width:15%">
                                                <a href="#" data-type="select" data-pk="{{ $g82s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g82s->id) }}"
                                                    data-title="Seleccionar estatus" data-value="{{$g82s->estatus }}"
                                                    class="estatus" data-name="estatus" onchange='cambioOpciones();' id="opciones">
                                                </a>
                                            </td>
                                            <td>
                                                <a href="#" data-type="textarea" data-pk="{{ $g82s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g82s->id) }}"
                                                    data-title="Comentarios" data-value="{{ $g82s->comentarios }}"
                                                    class="comentarios" data-name="comentarios" >
                                                </a>
                                            </td>
                                            <td>
                                                Hola
                                            </td>
                                            <td style="width:15%" id="actualizacion_fecha_{{$g82s->id}}" >
                                                @if($g82s->estatus == 2 )
                                                {{$g5s->updated_at}}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive">

                            <table class="table" style="font-size: 12px;">
                                <thead class="thead-dark" align="center">
                                    <tr>
                                        <th scope="col" style="width: 5%">INDICE</th>
                                        <th style="min-width:400px" COLSPAN="2">CONTROL</th>
                                        <th scope="col" style="width: 5%">APLICA</th>
                                        <th style="min-width:200px;" scope="col">JUSTIFICACIÓN</th>
                                        <th style="width:15%;" scope="col">ESTATUS</th>
                                        <th style="width:35%;" scope="col">COMENTARIOS</th>
                                        <th style="width:15px !important;" >APROBADOR</th>
                                        <th style="width:15px !important;" >FECHA DE APROBACIÓN</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr class="verdes">
                                        <td class="p-2 mb-2 text-white bg-info" style="font-size: 12px;" colspan="10">
                                            A.8.3 Manipulación de los soportes</td>
                                    </tr>
                                    @foreach ($gapda83s as $g83s)
                                        <tr>
                                            <th scope="row" style="width: 5%">
                                                {{ $g83s->anexo_indice }}
                                            </th>
                                            <td style="width:20%">
                                                {{ $g83s->anexo_politica }}
                                            </td>
                                            <td style="width:35%">
                                                {{ $g83s->anexo_descripcion }}
                                            </td>
                                            <td style="width:5%">
                                                <a href="#" data-type="select" data-pk="{{ $g83s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g83s->id) }}"
                                                    data-title="Seleccionar aplica" data-value="{{ $g83s->aplica }}"
                                                    class="aplica2" data-name="aplica">
                                                </a>
                                            </td>

                                            <td class="text-justify">
                                                <a href="#" data-type="textarea" data-pk="{{ $g83s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g83s->id) }}"
                                                    data-title="Justificacion"
                                                    data-value="{{ $g83s->justificacion }}" class="justificacion"
                                                    data-name="justificacion">
                                                </a>
                                            </td>
                                            <td style="width:15%">
                                                <a href="#" data-type="select" data-pk="{{ $g83s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g83s->id) }}"
                                                    data-title="Seleccionar estatus" data-value="{{$g83s->estatus }}"
                                                    class="estatus" data-name="estatus" onchange='cambioOpciones();' id="opciones">
                                                </a>
                                            </td>
                                            <td>
                                                <a href="#" data-type="textarea" data-pk="{{ $g83s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g83s->id) }}"
                                                    data-title="Comentarios" data-value="{{ $g83s->comentarios }}"
                                                    class="comentarios" data-name="comentarios" >
                                                </a>
                                            </td>
                                            <td>
                                                Hola
                                            </td>
                                            <td style="width:15%" id="actualizacion_fecha_{{$g83s->id}}" >
                                                @if($g83s->estatus == 2 )
                                                {{$g83s->updated_at}}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive">

                            <table class="table" style="font-size: 12px;">
                                <thead class="thead-dark" align="center">
                                    <tr>
                                        <th scope="col" style="width: 5%">INDICE</th>
                                        <th style="min-width:400px" COLSPAN="2">CONTROL</th>
                                        <th scope="col" style="width: 5%">APLICA</th>
                                        <th style="min-width:200px;" scope="col">JUSTIFICACIÓN</th>
                                        <th style="width:15%;" scope="col">ESTATUS</th>
                                        <th style="width:35%;" scope="col">COMENTARIOS</th>
                                        <th style="width:15px !important;" >APROBADOR</th>
                                        <th style="width:15px !important;" >FECHA DE APROBACIÓN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="p-2 mb-2 text-white bg-info" style="font-size: 12px;" class="negras">
                                        <td colspan="8">A.9 Control de acceso</td>
                                    </tr>
                                    <tr class="p-2 mb-2 text-white bg-info" style="font-size: 12px;" class="verdes">
                                        <td colspan="8">A.9.1 Requisitos del negocio para control de acceso</td>
                                    </tr>
                                    @foreach ($gapda91s as $g91s)
                                        <tr>
                                            <th scope="row" style="width: 5%">
                                                {{ $g91s->anexo_indice }}
                                            </th>
                                            <td style="width:20%">
                                                {{ $g91s->anexo_politica }}
                                            </td>
                                            <td style="width:35%">
                                                {{ $g91s->anexo_descripcion }}
                                            </td>
                                            <td style="width:5%">
                                                <a href="#" data-type="select" data-pk="{{ $g91s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g91s->id) }}"
                                                    data-title="Seleccionar aplica" data-value="{{ $g91s->aplica }}"
                                                    class="aplica2" data-name="aplica">
                                                </a>
                                            </td>

                                            <td class="text-justify">
                                                <a href="#" data-type="textarea" data-pk="{{ $g91s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g91s->id) }}"
                                                    data-title="Justificacion"
                                                    data-value="{{ $g91s->justificacion }}" class="justificacion"
                                                    data-name="justificacion">
                                                </a>
                                            </td>
                                            <td style="width:15%">
                                                <a href="#" data-type="select" data-pk="{{ $g91s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g91s->id) }}"
                                                    data-title="Seleccionar estatus" data-value="{{$g91s->estatus }}"
                                                    class="estatus" data-name="estatus" onchange='cambioOpciones();' id="opciones">
                                                </a>
                                            </td>
                                            <td>
                                                <a href="#" data-type="textarea" data-pk="{{ $g91s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g91s->id) }}"
                                                    data-title="Comentarios" data-value="{{ $g91s->comentarios }}"
                                                    class="comentarios" data-name="comentarios" >
                                                </a>
                                            </td>
                                            <td>
                                                Hola
                                            </td>
                                            <td style="width:15%" id="actualizacion_fecha_{{$g91s->id}}" >
                                                @if($g91s->estatus == 2 )
                                                {{$g91s->updated_at}}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive">

                            <table class="table" style="font-size: 12px;">
                                <thead class="thead-dark" align="center">
                                    <tr>
                                        <th scope="col" style="width: 5%">INDICE</th>
                                        <th style="min-width:400px" COLSPAN="2">CONTROL</th>
                                        <th scope="col" style="width: 5%">APLICA</th>
                                        <th style="min-width:200px;" scope="col">JUSTIFICACIÓN</th>
                                        <th style="width:15%;" scope="col">ESTATUS</th>
                                        <th style="width:35%;" scope="col">COMENTARIOS</th>
                                        <th style="width:15px !important;" >APROBADOR</th>
                                        <th style="width:15px !important;" >FECHA DE APROBACIÓN</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr class="verdes">
                                        <td class="p-2 mb-2 text-white bg-info" style="font-size: 12px;" colspan="10">
                                            A.9.2 Gestión de accesos de usuario</td>
                                    </tr>



                                    @foreach ($gapda92s as $g92s)
                                        <tr>
                                            <th scope="row" style="width: 5%">
                                                {{ $g92s->anexo_indice }}
                                            </th>
                                            <td style="width:20%">
                                                {{ $g92s->anexo_politica }}
                                            </td>
                                            <td style="width:35%">
                                                {{ $g92s->anexo_descripcion }}
                                            </td>
                                            <td style="width:5%">
                                                <a href="#" data-type="select" data-pk="{{ $g92s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g92s->id) }}"
                                                    data-title="Seleccionar aplica" data-value="{{ $g92s->aplica }}"
                                                    class="aplica2" data-name="aplica">
                                                </a>
                                            </td>

                                            <td class="text-justify">
                                                <a href="#" data-type="textarea" data-pk="{{ $g92s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g92s->id) }}"
                                                    data-title="Justificacion"
                                                    data-value="{{ $g92s->justificacion }}" class="justificacion"
                                                    data-name="justificacion">
                                                </a>
                                            </td>
                                            <td style="width:15%">
                                                <a href="#" data-type="select" data-pk="{{ $g92s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g92s->id) }}"
                                                    data-title="Seleccionar estatus" data-value="{{$g92s->estatus }}"
                                                    class="estatus" data-name="estatus" onchange='cambioOpciones();' id="opciones">
                                                </a>
                                            </td>
                                            <td>
                                                <a href="#" data-type="textarea" data-pk="{{ $g92s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g92s->id) }}"
                                                    data-title="Comentarios" data-value="{{ $g92s->comentarios }}"
                                                    class="comentarios" data-name="comentarios" >
                                                </a>
                                            </td>
                                            <td>
                                                Hola
                                            </td>
                                            <td style="width:15%" id="actualizacion_fecha_{{$g92s->id}}" >
                                                @if($g92s->estatus == 2 )
                                                {{$g92s->updated_at}}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive">

                            <table class="table" style="font-size: 12px;">
                                <thead class="thead-dark" align="center">
                                    <tr>
                                        <th scope="col" style="width: 5%">INDICE</th>
                                        <th style="min-width:400px" COLSPAN="2">CONTROL</th>
                                        <th scope="col" style="width: 5%">APLICA</th>
                                        <th style="min-width:200px;" scope="col">JUSTIFICACIÓN</th>
                                        <th style="width:15%;" scope="col">ESTATUS</th>
                                        <th style="width:35%;" scope="col">COMENTARIOS</th>
                                        <th style="width:15px !important;" >APROBADOR</th>
                                        <th style="width:15px !important;" >FECHA DE APROBACIÓN</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr class="verdes">
                                        <td class="p-2 mb-2 text-white bg-info" style="font-size: 12px;" colspan="10">
                                            A.9.3 Responsabilidades del usuario</td>
                                    </tr>

                                    @foreach ($gapda93s as $g93s)
                                        <tr>
                                            <th scope="row" style="width: 5%">
                                                {{ $g93s->anexo_indice }}
                                            </th>
                                            <td style="width:20%">
                                                {{ $g93s->anexo_politica }}
                                            </td>
                                            <td style="width:35%">
                                                {{ $g93s->anexo_descripcion }}
                                            </td>
                                            <td style="width:5%">
                                                <a href="#" data-type="select" data-pk="{{ $g93s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g93s->id) }}"
                                                    data-title="Seleccionar aplica" data-value="{{ $g93s->aplica }}"
                                                    class="aplica2" data-name="aplica">
                                                </a>
                                            </td>

                                            <td class="text-justify">
                                                <a href="#" data-type="textarea" data-pk="{{ $g93s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g93s->id) }}"
                                                    data-title="Justificacion"
                                                    data-value="{{ $g93s->justificacion }}" class="justificacion"
                                                    data-name="justificacion">
                                                </a>
                                            </td>
                                            <td style="width:15%">
                                                <a href="#" data-type="select" data-pk="{{ $g93s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g93s->id) }}"
                                                    data-title="Seleccionar estatus" data-value="{{$g93s->estatus }}"
                                                    class="estatus" data-name="estatus" onchange='cambioOpciones();' id="opciones">
                                                </a>
                                            </td>
                                            <td>
                                                <a href="#" data-type="textarea" data-pk="{{ $g93s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g93s->id) }}"
                                                    data-title="Comentarios" data-value="{{ $g93s->comentarios }}"
                                                    class="comentarios" data-name="comentarios" >
                                                </a>
                                            </td>
                                            <td>
                                                Hola
                                            </td>
                                            <td style="width:15%" id="actualizacion_fecha_{{$g93s->id}}" >
                                                @if($g93s->estatus == 2 )
                                                {{$g93s->updated_at}}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="table-responsive">

                            <table class="table" style="font-size: 12px;">
                                <thead class="thead-dark" align="center">
                                    <tr>
                                        <th scope="col" style="width: 5%">INDICE</th>
                                        <th style="min-width:400px" COLSPAN="2">CONTROL</th>
                                        <th scope="col" style="width: 5%">APLICA</th>
                                        <th style="min-width:200px;" scope="col">JUSTIFICACIÓN</th>
                                        <th style="width:15%;" scope="col">ESTATUS</th>
                                        <th style="width:35%;" scope="col">COMENTARIOS</th>
                                        <th style="width:15px !important;" >APROBADOR</th>
                                        <th style="width:15px !important;" >FECHA DE APROBACIÓN</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr class="verdes">
                                        <td class="p-2 mb-2 text-white bg-info" style="font-size: 12px;" colspan="10">
                                            A.9.4 Control de acceso a sistema y aplicaciones</td>
                                    </tr>
                                    @foreach ($gapda94s as $g94s)
                                        <tr>
                                            <th scope="row" style="width: 5%">
                                                {{ $g94s->anexo_indice }}
                                            </th>
                                            <td style="width:20%">
                                                {{ $g94s->anexo_politica }}
                                            </td>
                                            <td style="width:35%">
                                                {{ $g94s->anexo_descripcion }}
                                            </td>
                                            <td style="width:5%">
                                                <a href="#" data-type="select" data-pk="{{ $g94s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g94s->id) }}"
                                                    data-title="Seleccionar aplica" data-value="{{ $g94s->aplica }}"
                                                    class="aplica2" data-name="aplica">
                                                </a>
                                            </td>

                                            <td class="text-justify">
                                                <a href="#" data-type="textarea" data-pk="{{ $g94s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g94s->id) }}"
                                                    data-title="Justificacion"
                                                    data-value="{{ $g94s->justificacion }}" class="justificacion"
                                                    data-name="justificacion">
                                                </a>
                                            </td>
                                            <td style="width:15%">
                                                <a href="#" data-type="select" data-pk="{{ $g94s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g94s->id) }}"
                                                    data-title="Seleccionar estatus" data-value="{{$g94s->estatus }}"
                                                    class="estatus" data-name="estatus" onchange='cambioOpciones();' id="opciones">
                                                </a>
                                            </td>
                                            <td>
                                                <a href="#" data-type="textarea" data-pk="{{ $g94s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g94s->id) }}"
                                                    data-title="Comentarios" data-value="{{ $g94s->comentarios }}"
                                                    class="comentarios" data-name="comentarios" >
                                                </a>
                                            </td>
                                            <td>
                                                Hola
                                            </td>
                                            <td style="width:15%" id="actualizacion_fecha_{{$g94s->id}}" >
                                                @if($g94s->estatus == 2 )
                                                {{$g94s->updated_at}}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive">

                            <table class="table" style="font-size: 12px;">
                                <thead class="thead-dark" align="center">
                                    <tr>
                                        <th scope="col" style="width: 5%">INDICE</th>
                                        <th style="min-width:400px" COLSPAN="2">CONTROL</th>
                                        <th scope="col" style="width: 5%">APLICA</th>
                                        <th style="min-width:200px;" scope="col">JUSTIFICACIÓN</th>
                                        <th style="width:15%;" scope="col">ESTATUS</th>
                                        <th style="width:35%;" scope="col">COMENTARIOS</th>
                                        <th style="width:15px !important;" >APROBADOR</th>
                                        <th style="width:15px !important;" >FECHA DE APROBACIÓN</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr class="verdes">
                                        <td class="p-2 mb-2 text-white bg-info" style="font-size: 12px;" colspan="10">
                                            A.10 Criptografía</td>
                                    </tr>
                                    <tr class="verdes">
                                        <td class="p-2 mb-2 text-white bg-info" style="font-size: 12px;" colspan="10">
                                            A.10.1 Controles Criptografícos </td>
                                    </tr>
                                    @foreach ($gapda101s as $g101s)
                                        <tr>
                                            <th scope="row" style="width: 5%">
                                                {{ $g101s->anexo_indice }}
                                            </th>
                                            <td style="width:20%">
                                                {{ $g101s->anexo_politica }}
                                            </td>
                                            <td style="width:35%">
                                                {{ $g101s->anexo_descripcion }}
                                            </td>
                                            <td style="width:5%">
                                                <a href="#" data-type="select" data-pk="{{ $g101s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g101s->id) }}"
                                                    data-title="Seleccionar aplica"
                                                    data-value="{{ $g101s->aplica }}" class="aplica2"
                                                    data-name="aplica">
                                                </a>
                                            </td>

                                            <td class="text-justify">
                                                <a href="#" data-type="textarea" data-pk="{{ $g101s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g101s->id) }}"
                                                    data-title="Justificacion"
                                                    data-value="{{ $g101s->justificacion }}" class="justificacion"
                                                    data-name="justificacion">
                                                </a>
                                            </td>
                                            <td style="width:15%">
                                                <a href="#" data-type="select" data-pk="{{ $g101s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g101s->id) }}"
                                                    data-title="Seleccionar estatus" data-value="{{$g101s->estatus }}"
                                                    class="estatus" data-name="estatus" onchange='cambioOpciones();' id="opciones">
                                                </a>
                                            </td>
                                            <td>
                                                <a href="#" data-type="textarea" data-pk="{{ $g101s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g101s->id) }}"
                                                    data-title="Comentarios" data-value="{{ $g101s->comentarios }}"
                                                    class="comentarios" data-name="comentarios" >
                                                </a>
                                            </td>
                                            <td>
                                                Hola
                                            </td>
                                            <td style="width:15%" id="actualizacion_fecha_{{$g101s->id}}" >
                                                @if($g101s->estatus == 2 )
                                                {{$g101s->updated_at}}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive">

                            <table class="table" style="font-size: 12px;">
                                <thead class="thead-dark" align="center">
                                    <tr>
                                        <th scope="col" style="width: 5%">INDICE</th>
                                        <th style="min-width:400px" COLSPAN="2">CONTROL</th>
                                        <th scope="col" style="width: 5%">APLICA</th>
                                        <th style="min-width:200px;" scope="col">JUSTIFICACIÓN</th>
                                        <th style="width:15%;" scope="col">ESTATUS</th>
                                        <th style="width:35%;" scope="col">COMENTARIOS</th>
                                        <th style="width:15px !important;" >APROBADOR</th>
                                        <th style="width:15px !important;" >FECHA DE APROBACIÓN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="verdes">
                                        <td class="p-2 mb-2 text-white bg-info" style="font-size: 12px;" colspan="10">
                                            A.11 Seguridad Física y del Entorno</td>
                                    </tr>
                                    <tr class="verdes">
                                        <td class="p-2 mb-2 text-white bg-info" style="font-size: 12px;" colspan="10">
                                            A.11.1 Áreas seguras </td>
                                    </tr>
                                    @foreach ($gapda111s as $g111s)
                                        <tr>
                                            <th scope="row" style="width: 5%">
                                                {{ $g111s->anexo_indice }}
                                            </th>
                                            <td style="width:20%">
                                                {{ $g111s->anexo_politica }}
                                            </td>
                                            <td style="width:35%">
                                                {{ $g111s->anexo_descripcion }}
                                            </td>
                                            <td style="width:5%">
                                                <a href="#" data-type="select" data-pk="{{ $g111s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g111s->id) }}"
                                                    data-title="Seleccionar aplica"
                                                    data-value="{{ $g111s->aplica }}" class="aplica2"
                                                    data-name="aplica">
                                                </a>
                                            </td>

                                            <td class="text-justify">
                                                <a href="#" data-type="textarea" data-pk="{{ $g111s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g111s->id) }}"
                                                    data-title="Justificacion"
                                                    data-value="{{ $g111s->justificacion }}" class="justificacion"
                                                    data-name="justificacion">
                                                </a>
                                            </td>
                                            <td style="width:15%">
                                                <a href="#" data-type="select" data-pk="{{ $g111s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g111s->id) }}"
                                                    data-title="Seleccionar estatus" data-value="{{$g111s->estatus }}"
                                                    class="estatus" data-name="estatus" onchange='cambioOpciones();' id="opciones">
                                                </a>
                                            </td>
                                            <td>
                                                <a href="#" data-type="textarea" data-pk="{{ $g111s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g111s->id) }}"
                                                    data-title="Comentarios" data-value="{{ $g111s->comentarios }}"
                                                    class="comentarios" data-name="comentarios" >
                                                </a>
                                            </td>
                                            <td>
                                                Hola
                                            </td>
                                            <td style="width:15%" id="actualizacion_fecha_{{$g111s->id}}" >
                                                @if($g111s->estatus == 2 )
                                                {{$g111s->updated_at}}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive">

                            <table class="table" style="font-size: 12px;">
                                <thead class="thead-dark" align="center">
                                    <tr>
                                        <th scope="col" style="width: 5%">INDICE</th>
                                        <th style="min-width:400px" COLSPAN="2">CONTROL</th>
                                        <th scope="col" style="width: 5%">APLICA</th>
                                        <th style="min-width:200px;" scope="col">JUSTIFICACIÓN</th>
                                        <th style="width:15%;" scope="col">ESTATUS</th>
                                        <th style="width:35%;" scope="col">COMENTARIOS</th>
                                        <th style="width:15px !important;" >APROBADOR</th>
                                        <th style="width:15px !important;" >FECHA DE APROBACIÓN</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr class="verdes">
                                        <td class="p-2 mb-2 text-white bg-info" style="font-size: 12px;" colspan="10">
                                            A.11.2 Seguridad de los Equipos</td>
                                    </tr>

                                    @foreach ($gapda112s as $g112s)
                                        <tr>
                                            <th scope="row" style="width: 5%">
                                                {{ $g112s->anexo_indice }}
                                            </th>
                                            <td style="width:20%">
                                                {{ $g112s->anexo_politica }}
                                            </td>
                                            <td style="width:35%">
                                                {{ $g112s->anexo_descripcion }}
                                            </td>
                                            <td style="width:5%">
                                                <a href="#" data-type="select" data-pk="{{ $g112s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g112s->id) }}"
                                                    data-title="Seleccionar aplica"
                                                    data-value="{{ $g112s->aplica }}" class="aplica2"
                                                    data-name="aplica">
                                                </a>
                                            </td>

                                            <td class="text-justify">
                                                <a href="#" data-type="textarea" data-pk="{{ $g112s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g112s->id) }}"
                                                    data-title="Justificacion"
                                                    data-value="{{ $g112s->justificacion }}" class="justificacion"
                                                    data-name="justificacion">
                                                </a>
                                            </td>

                                            <td style="width:15%">
                                                <a href="#" data-type="select" data-pk="{{ $g112s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g112s->id) }}"
                                                    data-title="Seleccionar estatus" data-value="{{$g112s->estatus }}"
                                                    class="estatus" data-name="estatus" onchange='cambioOpciones();' id="opciones">
                                                </a>
                                            </td>
                                            <td>
                                                <a href="#" data-type="textarea" data-pk="{{ $g112s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g112s->id) }}"
                                                    data-title="Comentarios" data-value="{{ $g112s->comentarios }}"
                                                    class="comentarios" data-name="comentarios" >
                                                </a>
                                            </td>
                                            <td>
                                                Hola
                                            </td>
                                            <td style="width:15%" id="actualizacion_fecha_{{$g112s->id}}" >
                                                @if($g112s->estatus == 2 )
                                                {{$g112s->updated_at}}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive">

                            <table class="table" style="font-size: 12px;">
                                <thead class="thead-dark" align="center">
                                    <tr>
                                        <th scope="col" style="width: 5%">INDICE</th>
                                        <th style="min-width:400px" COLSPAN="2">CONTROL</th>
                                        <th scope="col" style="width: 5%">APLICA</th>
                                        <th style="min-width:200px;" scope="col">JUSTIFICACIÓN</th>
                                        <th style="width:15%;" scope="col">ESTATUS</th>
                                        <th style="width:35%;" scope="col">COMENTARIOS</th>
                                        <th style="width:15px !important;" >APROBADOR</th>
                                        <th style="width:15px !important;" >FECHA DE APROBACIÓN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="verdes">
                                        <td class="p-2 mb-2 text-white bg-info" style="font-size: 12px;" colspan="10">
                                            A.12 Seguridad de las Operaciones</td>
                                    </tr>
                                    <tr class="verdes">
                                        <td class="p-2 mb-2 text-white bg-info" style="font-size: 12px;" colspan="10">
                                            A.12.1 Procedimientos y Responsbilidades Operacionales</td>
                                    </tr>
                                    @foreach ($gapda121s as $g121s)
                                        <tr>
                                            <th scope="row" style="width: 5%">
                                                {{ $g121s->anexo_indice }}
                                            </th>
                                            <td style="width:20%">
                                                {{ $g121s->anexo_politica }}
                                            </td>
                                            <td style="width:35%">
                                                {{ $g121s->anexo_descripcion }}
                                            </td>
                                            <td style="width:5%">
                                                <a href="#" data-type="select" data-pk="{{ $g121s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g121s->id) }}"
                                                    data-title="Seleccionar aplica"
                                                    data-value="{{ $g121s->aplica }}" class="aplica2"
                                                    data-name="aplica">
                                                </a>
                                            </td>

                                            <td class="text-justify">
                                                <a href="#" data-type="textarea" data-pk="{{ $g121s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g121s->id) }}"
                                                    data-title="Justificacion"
                                                    data-value="{{ $g121s->justificacion }}" class="justificacion"
                                                    data-name="justificacion">
                                                </a>
                                            </td>
                                            <td style="width:15%">
                                                <a href="#" data-type="select" data-pk="{{ $g121s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g121s->id) }}"
                                                    data-title="Seleccionar estatus" data-value="{{$g121s->estatus }}"
                                                    class="estatus" data-name="estatus" onchange='cambioOpciones();' id="opciones">
                                                </a>
                                            </td>
                                            <td>
                                                <a href="#" data-type="textarea" data-pk="{{ $g121s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g121s->id) }}"
                                                    data-title="Comentarios" data-value="{{ $g121s->comentarios }}"
                                                    class="comentarios" data-name="comentarios" >
                                                </a>
                                            </td>
                                            <td>
                                                Hola
                                            </td>
                                            <td style="width:15%" id="actualizacion_fecha_{{$g121s->id}}" >
                                                @if($g121s->estatus == 2 )
                                                {{$g121s->updated_at}}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive">

                            <table class="table" style="font-size: 12px;">
                                <thead class="thead-dark" align="center">
                                    <tr>
                                        <th scope="col" style="width: 5%">INDICE</th>
                                        <th style="min-width:400px" COLSPAN="2">CONTROL</th>
                                        <th scope="col" style="width: 5%">APLICA</th>
                                        <th style="min-width:200px;" scope="col">JUSTIFICACIÓN</th>
                                        <th style="width:15%;" scope="col">ESTATUS</th>
                                        <th style="width:35%;" scope="col">COMENTARIOS</th>
                                        <th style="width:15px !important;" >APROBADOR</th>
                                        <th style="width:15px !important;" >FECHA DE APROBACIÓN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="verdes">
                                        <td class="p-2 mb-2 text-white bg-info" style="font-size: 12px;" colspan="10">
                                            A.12.2 Protección contra el software malicioso</td>
                                    </tr>
                                    @foreach ($gapda122s as $g122s)
                                        <tr>
                                            <th scope="row" style="width: 5%">
                                                {{ $g122s->anexo_indice }}
                                            </th>
                                            <td style="width:20%">
                                                {{ $g122s->anexo_politica }}
                                            </td>
                                            <td style="width:35%">
                                                {{ $g122s->anexo_descripcion }}
                                            </td>
                                            <td style="width:5%">
                                                <a href="#" data-type="select" data-pk="{{ $g122s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g122s->id) }}"
                                                    data-title="Seleccionar aplica"
                                                    data-value="{{ $g122s->aplica }}" class="aplica2"
                                                    data-name="aplica">
                                                </a>
                                            </td>
                                            <td class="text-justify">
                                                <a href="#" data-type="textarea" data-pk="{{ $g122s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g122s->id) }}"
                                                    data-title="Justificacion"
                                                    data-value="{{ $g122s->justificacion }}" class="justificacion"
                                                    data-name="justificacion">
                                                </a>
                                            </td>
                                            <td style="width:15%">
                                                <a href="#" data-type="select" data-pk="{{ $g122s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g122s->id) }}"
                                                    data-title="Seleccionar estatus" data-value="{{$g122s->estatus }}"
                                                    class="estatus" data-name="estatus" onchange='cambioOpciones();' id="opciones">
                                                </a>
                                            </td>
                                            <td>
                                                <a href="#" data-type="textarea" data-pk="{{ $g122s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g122s->id) }}"
                                                    data-title="Comentarios" data-value="{{ $g122s->comentarios }}"
                                                    class="comentarios" data-name="comentarios" >
                                                </a>
                                            </td>
                                            <td>
                                                Hola
                                            </td>
                                            <td style="width:15%" id="actualizacion_fecha_{{$g122s->id}}" >
                                                @if($g122s->estatus == 2 )
                                                {{$g122s->updated_at}}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive">

                            <table class="table" style="font-size: 12px;">
                                <thead class="thead-dark" align="center">
                                    <tr>
                                        <th scope="col" style="width: 5%">INDICE</th>
                                        <th style="min-width:400px" COLSPAN="2">CONTROL</th>
                                        <th scope="col" style="width: 5%">APLICA</th>
                                        <th style="min-width:200px;" scope="col">JUSTIFICACIÓN</th>
                                        <th style="width:15%;" scope="col">ESTATUS</th>
                                        <th style="width:35%;" scope="col">COMENTARIOS</th>
                                        <th style="width:15px !important;" >APROBADOR</th>
                                        <th style="width:15px !important;" >FECHA DE APROBACIÓN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="verdes">
                                        <td class="p-2 mb-2 text-white bg-info" style="font-size: 12px;" colspan="10">
                                            A.12.3 Copias de Seguridad</td>
                                    </tr>
                                    @foreach ($gapda123s as $g123s)
                                        <tr>
                                            <th scope="row" style="width: 5%">
                                                {{ $g123s->anexo_indice }}
                                            </th>
                                            <td style="width:20%">
                                                {{ $g123s->anexo_politica }}
                                            </td>
                                            <td style="width:35%">
                                                {{ $g123s->anexo_descripcion }}
                                            </td>
                                            <td style="width:5%">
                                                <a href="#" data-type="select" data-pk="{{ $g123s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g123s->id) }}"
                                                    data-title="Seleccionar aplica"
                                                    data-value="{{ $g123s->aplica }}" class="aplica2"
                                                    data-name="aplica">
                                                </a>
                                            </td>

                                            <td class="text-justify">
                                                <a href="#" data-type="textarea" data-pk="{{ $g123s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g123s->id) }}"
                                                    data-title="Justificacion"
                                                    data-value="{{ $g123s->justificacion }}" class="justificacion"
                                                    data-name="justificacion">
                                                </a>
                                            </td>
                                            <td style="width:15%">
                                                <a href="#" data-type="select" data-pk="{{ $g123s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g123s->id) }}"
                                                    data-title="Seleccionar estatus" data-value="{{$g123s->estatus }}"
                                                    class="estatus" data-name="estatus" onchange='cambioOpciones();' id="opciones">
                                                </a>
                                            </td>
                                            <td>
                                                <a href="#" data-type="textarea" data-pk="{{ $g123s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g123s->id) }}"
                                                    data-title="Comentarios" data-value="{{ $g123s->comentarios }}"
                                                    class="comentarios" data-name="comentarios" >
                                                </a>
                                            </td>
                                            <td>
                                                Hola
                                            </td>
                                            <td style="width:15%" id="actualizacion_fecha_{{$g123s->id}}" >
                                                @if($g123s->estatus == 2 )
                                                {{$g123s->updated_at}}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive">

                            <table class="table" style="font-size: 12px;">
                                <thead class="thead-dark" align="center">
                                    <tr>
                                        <th scope="col" style="width: 5%">INDICE</th>
                                        <th style="min-width:400px" COLSPAN="2">CONTROL</th>
                                        <th scope="col" style="width: 5%">APLICA</th>
                                        <th style="min-width:200px;" scope="col">JUSTIFICACIÓN</th>
                                        <th style="width:15%;" scope="col">ESTATUS</th>
                                        <th style="width:35%;" scope="col">COMENTARIOS</th>
                                        <th style="width:15px !important;" >APROBADOR</th>
                                        <th style="width:15px !important;" >FECHA DE APROBACIÓN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="verdes">
                                        <td class="p-2 mb-2 text-white bg-info" style="font-size: 12px;" colspan="10">
                                            A.12.4 Registro y Supervisión </td>
                                    </tr>
                                    @foreach ($gapda124s as $g124s)
                                        <tr>
                                            <th scope="row" style="width: 5%">
                                                {{ $g124s->anexo_indice }}
                                            </th>
                                            <td style="width:20%">
                                                {{ $g124s->anexo_politica }}
                                            </td>
                                            <td style="width:35%">
                                                {{ $g124s->anexo_descripcion }}
                                            </td>
                                            <td style="width:5%">
                                                <a href="#" data-type="select" data-pk="{{ $g124s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g124s->id) }}"
                                                    data-title="Seleccionar aplica"
                                                    data-value="{{ $g124s->aplica }}" class="aplica2"
                                                    data-name="aplica">
                                                </a>
                                            </td>

                                            <td class="text-justify">
                                                <a href="#" data-type="textarea" data-pk="{{ $g124s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g124s->id) }}"
                                                    data-title="Justificacion"
                                                    data-value="{{ $g124s->justificacion }}" class="justificacion"
                                                    data-name="justificacion">
                                                </a>
                                            </td>
                                            <td style="width:15%">
                                                <a href="#" data-type="select" data-pk="{{ $g124s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g124s->id) }}"
                                                    data-title="Seleccionar estatus" data-value="{{$g124s->estatus }}"
                                                    class="estatus" data-name="estatus" onchange='cambioOpciones();' id="opciones">
                                                </a>
                                            </td>
                                            <td>
                                                <a href="#" data-type="textarea" data-pk="{{ $g124s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g124s->id) }}"
                                                    data-title="Comentarios" data-value="{{ $g124s->comentarios }}"
                                                    class="comentarios" data-name="comentarios" >
                                                </a>
                                            </td>
                                            <td>
                                                Hola
                                            </td>
                                            <td style="width:15%" id="actualizacion_fecha_{{$g124s->id}}" >
                                                @if($g124s->estatus == 2 )
                                                {{$g124s->updated_at}}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive">

                            <table class="table" style="font-size: 12px;">
                                <thead class="thead-dark" align="center">
                                    <tr>
                                        <th scope="col" style="width: 5%">INDICE</th>
                                        <th style="min-width:400px" COLSPAN="2">CONTROL</th>
                                        <th scope="col" style="width: 5%">APLICA</th>
                                        <th style="min-width:200px;" scope="col">JUSTIFICACIÓN</th>
                                        <th style="width:15%;" scope="col">ESTATUS</th>
                                        <th style="width:35%;" scope="col">COMENTARIOS</th>
                                        <th style="width:15px !important;" >APROBADOR</th>
                                        <th style="width:15px !important;" >FECHA DE APROBACIÓN</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr class="verdes">
                                        <td class="p-2 mb-2 text-white bg-info" style="font-size: 12px;" colspan="10">
                                            A.12.5 Control de Software y Explotación </td>
                                    </tr>
                                    @foreach ($gapda125s as $g125s)
                                        <tr>
                                            <th scope="row" style="width: 5%">
                                                {{ $g125s->anexo_indice }}
                                            </th>
                                            <td style="width:20%">
                                                {{ $g125s->anexo_politica }}
                                            </td>
                                            <td style="width:35%">
                                                {{ $g125s->anexo_descripcion }}
                                            </td>
                                            <td style="width:5%">
                                                <a href="#" data-type="select" data-pk="{{ $g125s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g125s->id) }}"
                                                    data-title="Seleccionar aplica"
                                                    data-value="{{ $g125s->aplica }}" class="aplica2"
                                                    data-name="aplica">
                                                </a>
                                            </td>

                                            <td class="text-justify">
                                                <a href="#" data-type="textarea" data-pk="{{ $g125s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g125s->id) }}"
                                                    data-title="Justificacion"
                                                    data-value="{{ $g125s->justificacion }}" class="justificacion"
                                                    data-name="justificacion">
                                                </a>
                                            </td>
                                            <td style="width:15%">
                                                <a href="#" data-type="select" data-pk="{{ $g125s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g125s->id) }}"
                                                    data-title="Seleccionar estatus" data-value="{{$g125s->estatus }}"
                                                    class="estatus" data-name="estatus" onchange='cambioOpciones();' id="opciones">
                                                </a>
                                            </td>
                                            <td>
                                                <a href="#" data-type="textarea" data-pk="{{ $g125s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g125s->id) }}"
                                                    data-title="Comentarios" data-value="{{ $g125s->comentarios }}"
                                                    class="comentarios" data-name="comentarios" >
                                                </a>
                                            </td>
                                            <td>
                                                Hola
                                            </td>
                                            <td style="width:15%" id="actualizacion_fecha_{{$g125s->id}}" >
                                                @if($g125s->estatus == 2 )
                                                {{$g125s->updated_at}}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive">

                            <table class="table" style="font-size: 12px;">
                                <thead class="thead-dark" align="center">
                                    <tr>
                                        <th scope="col" style="width: 5%">INDICE</th>
                                        <th style="min-width:400px" COLSPAN="2">CONTROL</th>
                                        <th scope="col" style="width: 5%">APLICA</th>
                                        <th style="min-width:200px;" scope="col">JUSTIFICACIÓN</th>
                                        <th style="width:15%;" scope="col">ESTATUS</th>
                                        <th style="width:35%;" scope="col">COMENTARIOS</th>
                                        <th style="width:15px !important;" >APROBADOR</th>
                                        <th style="width:15px !important;" >FECHA DE APROBACIÓN</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr class="verdes">
                                        <td class="p-2 mb-2 text-white bg-info" style="font-size: 12px;" colspan="10">
                                            A.12.6 Gestión de la Vulnerabilidad Técnica </td>
                                    </tr>
                                    @foreach ($gapda126s as $g126s)
                                        <tr>
                                            <th scope="row" style="width: 5%">
                                                {{ $g126s->anexo_indice }}
                                            </th>
                                            <td style="width:20%">
                                                {{ $g126s->anexo_politica }}
                                            </td>
                                            <td style="width:35%">
                                                {{ $g126s->anexo_descripcion }}
                                            </td>
                                            <td style="width:5%">
                                                <a href="#" data-type="select" data-pk="{{ $g126s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g126s->id) }}"
                                                    data-title="Seleccionar aplica"
                                                    data-value="{{ $g126s->aplica }}" class="aplica2"
                                                    data-name="aplica">
                                                </a>
                                            </td>

                                            <td class="text-justify">
                                                <a href="#" data-type="textarea" data-pk="{{ $g126s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g126s->id) }}"
                                                    data-title="Justificacion"
                                                    data-value="{{ $g126s->justificacion }}" class="justificacion"
                                                    data-name="justificacion">
                                                </a>
                                            </td>
                                            <td style="width:15%">
                                                <a href="#" data-type="select" data-pk="{{ $g126s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g126s->id) }}"
                                                    data-title="Seleccionar estatus" data-value="{{$g126s->estatus }}"
                                                    class="estatus" data-name="estatus" onchange='cambioOpciones();' id="opciones">
                                                </a>
                                            </td>
                                            <td>
                                                <a href="#" data-type="textarea" data-pk="{{ $g126s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g126s->id) }}"
                                                    data-title="Comentarios" data-value="{{ $g126s->comentarios }}"
                                                    class="comentarios" data-name="comentarios" >
                                                </a>
                                            </td>
                                            <td>
                                                Hola
                                            </td>
                                            <td style="width:15%" id="actualizacion_fecha_{{$g126s->id}}" >
                                                @if($g126s->estatus == 2 )
                                                {{$g126s->updated_at}}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive">

                            <table class="table" style="font-size: 12px;">
                                <thead class="thead-dark" align="center">
                                    <tr>
                                        <th scope="col" style="width: 5%">INDICE</th>
                                        <th style="min-width:400px" COLSPAN="2">CONTROL</th>
                                        <th scope="col" style="width: 5%">APLICA</th>
                                        <th style="min-width:200px;" scope="col">JUSTIFICACIÓN</th>
                                        <th style="width:15%;" scope="col">ESTATUS</th>
                                        <th style="width:35%;" scope="col">COMENTARIOS</th>
                                        <th style="width:15px !important;" >APROBADOR</th>
                                        <th style="width:15px !important;" >FECHA DE APROBACIÓN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="verdes">
                                        <td class="p-2 mb-2 text-white bg-info" style="font-size: 12px;" colspan="10">
                                            A.12.7 Consideraciones sobre la auditoria de sistemas de
                                            información</td>
                                    </tr>
                                    @foreach ($gapda127s as $g127s)
                                        <tr>
                                            <th scope="row" style="width: 5%">
                                                {{ $g127s->anexo_indice }}
                                            </th>
                                            <td style="width:20%">
                                                {{ $g127s->anexo_politica }}
                                            </td>
                                            <td style="width:35%">
                                                {{ $g127s->anexo_descripcion }}
                                            </td>
                                            <td style="width:5%">
                                                <a href="#" data-type="select" data-pk="{{ $g127s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g127s->id) }}"
                                                    data-title="Seleccionar aplica"
                                                    data-value="{{ $g127s->aplica }}" class="aplica2"
                                                    data-name="aplica">
                                                </a>
                                            </td>

                                            <td class="text-justify">
                                                <a href="#" data-type="textarea" data-pk="{{ $g127s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g127s->id) }}"
                                                    data-title="Justificacion"
                                                    data-value="{{ $g127s->justificacion }}" class="justificacion"
                                                    data-name="justificacion">
                                                </a>
                                            </td>
                                            <td style="width:15%">
                                                <a href="#" data-type="select" data-pk="{{ $g127s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g127s->id) }}"
                                                    data-title="Seleccionar estatus" data-value="{{$g127s->estatus }}"
                                                    class="estatus" data-name="estatus" onchange='cambioOpciones();' id="opciones">
                                                </a>
                                            </td>
                                            <td>
                                                <a href="#" data-type="textarea" data-pk="{{ $g127s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g127s->id) }}"
                                                    data-title="Comentarios" data-value="{{ $g127s->comentarios }}"
                                                    class="comentarios" data-name="comentarios" >
                                                </a>
                                            </td>
                                            <td>
                                                Hola
                                            </td>
                                            <td style="width:15%" id="actualizacion_fecha_{{$g127s->id}}" >
                                                @if($g127s->estatus == 2 )
                                                {{$g127s->updated_at}}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive">

                            <table class="table" style="font-size: 12px;">
                                <thead class="thead-dark" align="center">
                                    <tr>
                                        <th scope="col" style="width: 5%">INDICE</th>
                                        <th style="min-width:400px" COLSPAN="2">CONTROL</th>
                                        <th scope="col" style="width: 5%">APLICA</th>
                                        <th style="min-width:200px;" scope="col">JUSTIFICACIÓN</th>
                                        <th style="width:15%;" scope="col">ESTATUS</th>
                                        <th style="width:35%;" scope="col">COMENTARIOS</th>
                                        <th style="width:15px !important;" >APROBADOR</th>
                                        <th style="width:15px !important;" >FECHA DE APROBACIÓN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="verdes">
                                        <td class="p-2 mb-2 text-white bg-info" style="font-size: 12px;" colspan="10">
                                            A.13 Seguridad de las comunicaciones</td>
                                    </tr>
                                    <tr class="verdes">
                                        <td class="p-2 mb-2 text-white bg-info" style="font-size: 12px;" colspan="10">
                                            A.13.1 Gestión de la seguridad de redes</td>
                                    </tr>
                                    @foreach ($gapda131s as $g131s)
                                        <tr>
                                            <th scope="row" style="width: 5%">
                                                {{ $g131s->anexo_indice }}
                                            </th>
                                            <td style="width:20%">
                                                {{ $g131s->anexo_politica }}
                                            </td>
                                            <td style="width:35%">
                                                {{ $g131s->anexo_descripcion }}
                                            </td>
                                            <td style="width:5%">
                                                <a href="#" data-type="select" data-pk="{{ $g131s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g131s->id) }}"
                                                    data-title="Seleccionar aplica"
                                                    data-value="{{ $g131s->aplica }}" class="aplica2"
                                                    data-name="aplica">
                                                </a>
                                            </td>

                                            <td class="text-justify">
                                                <a href="#" data-type="textarea" data-pk="{{ $g131s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g131s->id) }}"
                                                    data-title="Justificacion"
                                                    data-value="{{ $g131s->justificacion }}" class="justificacion"
                                                    data-name="justificacion">
                                                </a>
                                            </td>
                                            <td style="width:15%">
                                                <a href="#" data-type="select" data-pk="{{ $g131s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g131s->id) }}"
                                                    data-title="Seleccionar estatus" data-value="{{$g131s->estatus }}"
                                                    class="estatus" data-name="estatus" onchange='cambioOpciones();' id="opciones">
                                                </a>
                                            </td>
                                            <td class="text-justify">
                                                <a href="#" data-type="textarea" data-pk="{{ $g131s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g131s->id) }}"
                                                    data-title="Comentarios" data-value="{{ $g131s->comentarios }}"
                                                    class="comentarios" data-name="comentarios" >
                                                </a>
                                            </td>
                                            <td>
                                                Hola
                                            </td>
                                            <td style="width:15%" id="actualizacion_fecha_{{$g131s->id}}" >
                                                @if($g131s->estatus == 2 )
                                                {{$g131s->updated_at}}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive">

                            <table class="table" style="font-size: 12px;">
                                <thead class="thead-dark" align="center">
                                    <tr>
                                        <th scope="col" style="width: 5%">INDICE</th>
                                        <th style="min-width:400px" COLSPAN="2">CONTROL</th>
                                        <th scope="col" style="width: 5%">APLICA</th>
                                        <th style="min-width:200px;" scope="col">JUSTIFICACIÓN</th>
                                        <th style="width:15%;" scope="col">ESTATUS</th>
                                        <th style="width:35%;" scope="col">COMENTARIOS</th>
                                        <th style="width:15px !important;" >APROBADOR</th>
                                        <th style="width:15px !important;" >FECHA DE APROBACIÓN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="verdes">
                                        <td class="p-2 mb-2 text-white bg-info" style="font-size: 12px;" colspan="10">
                                            A.13.2 Intercambio de información</td>
                                    </tr>
                                    @foreach ($gapda132s as $g132s)
                                        <tr>
                                            <th scope="row" style="width: 5%">
                                                {{ $g132s->anexo_indice }}
                                            </th>
                                            <td style="width:20%">
                                                {{ $g132s->anexo_politica }}
                                            </td>
                                            <td style="width:35%">
                                                {{ $g132s->anexo_descripcion }}
                                            </td>
                                            <td style="width:5%">
                                                <a href="#" data-type="select" data-pk="{{ $g132s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g132s->id) }}"
                                                    data-title="Seleccionar aplica"
                                                    data-value="{{ $g132s->aplica }}" class="aplica2"
                                                    data-name="aplica">
                                                </a>
                                            </td>

                                            <td class="text-justify">
                                                <a href="#" data-type="textarea" data-pk="{{ $g132s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g132s->id) }}"
                                                    data-title="Justificacion"
                                                    data-value="{{ $g132s->justificacion }}" class="justificacion"
                                                    data-name="justificacion">
                                                </a>
                                            </td>
                                            <td style="width:15%">
                                                <a href="#" data-type="select" data-pk="{{ $g132s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g132s->id) }}"
                                                    data-title="Seleccionar estatus" data-value="{{$g132s->estatus }}"
                                                    class="estatus" data-name="estatus" onchange='cambioOpciones();' id="opciones">
                                                </a>
                                            </td>
                                            <td>
                                                <a href="#" data-type="textarea" data-pk="{{ $g132s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g132s->id) }}"
                                                    data-title="Comentarios" data-value="{{ $g132s->comentarios }}"
                                                    class="comentarios" data-name="comentarios" >
                                                </a>
                                            </td>
                                            <td>
                                                Hola
                                            </td>
                                            <td style="width:15%" id="actualizacion_fecha_{{$g132s->id}}" >
                                                @if($g132s->estatus == 2 )
                                                {{$g132s->updated_at}}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive">

                            <table class="table" style="font-size: 12px;">
                                <thead class="thead-dark" align="center">
                                    <tr>
                                        <th scope="col" style="width: 5%">INDICE</th>
                                        <th style="min-width:400px" COLSPAN="2">CONTROL</th>
                                        <th scope="col" style="width: 5%">APLICA</th>
                                        <th style="min-width:200px;" scope="col">JUSTIFICACIÓN</th>
                                        <th style="width:15%;" scope="col">ESTATUS</th>
                                        <th style="width:35%;" scope="col">COMENTARIOS</th>
                                        <th style="width:15px !important;" >APROBADOR</th>
                                        <th style="width:15px !important;" >FECHA DE APROBACIÓN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="verdes">
                                        <td class="p-2 mb-2 text-white bg-info" style="font-size: 12px;" colspan="10">
                                            A.14 Adquisición, desarrollo y mantenimiento de los sistemas
                                            de información</td>
                                    </tr>
                                    <tr class="verdes">
                                        <td class="p-2 mb-2 text-white bg-info" style="font-size: 12px;" colspan="10">
                                            A.14.1 Requisitos de seguridad en sistemas de información
                                        </td>
                                    </tr>
                                    @foreach ($gapda141s as $g141s)
                                        <tr>
                                            <th scope="row" style="width: 5%">
                                                {{ $g141s->anexo_indice }}
                                            </th>
                                            <td style="width:20%">
                                                {{ $g141s->anexo_politica }}
                                            </td>
                                            <td style="width:35%">
                                                {{ $g141s->anexo_descripcion }}
                                            </td>
                                            <td style="width:5%">
                                                <a href="#" data-type="select" data-pk="{{ $g141s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g141s->id) }}"
                                                    data-title="Seleccionar aplica"
                                                    data-value="{{ $g141s->aplica }}" class="aplica2"
                                                    data-name="aplica">
                                                </a>
                                            </td>

                                            <td class="text-justify">
                                                <a href="#" data-type="textarea" data-pk="{{ $g141s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g141s->id) }}"
                                                    data-title="Justificacion"
                                                    data-value="{{ $g141s->justificacion }}" class="justificacion"
                                                    data-name="justificacion">
                                                </a>
                                            </td>
                                            <td style="width:15%">
                                                <a href="#" data-type="select" data-pk="{{ $g141s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g141s->id) }}"
                                                    data-title="Seleccionar estatus" data-value="{{$g141s->estatus }}"
                                                    class="estatus" data-name="estatus" onchange='cambioOpciones();' id="opciones">
                                                </a>
                                            </td>
                                            <td>
                                                <a href="#" data-type="textarea" data-pk="{{ $g141s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g141s->id) }}"
                                                    data-title="Comentarios" data-value="{{ $g141s->comentarios }}"
                                                    class="comentarios" data-name="comentarios" >
                                                </a>
                                            </td>
                                            <td>
                                                Hola
                                            </td>
                                            <td style="width:15%" id="actualizacion_fecha_{{$g141s->id}}" >
                                                @if($g141s->estatus == 2 )
                                                {{$g141s->updated_at}}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive">

                            <table class="table" style="font-size: 12px;">
                                <thead class="thead-dark" align="center">
                                    <tr>
                                        <th scope="col" style="width: 5%">INDICE</th>
                                        <th style="min-width:400px" COLSPAN="2">CONTROL</th>
                                        <th scope="col" style="width: 5%">APLICA</th>
                                        <th style="min-width:200px;" scope="col">JUSTIFICACIÓN</th>
                                        <th style="width:15%;" scope="col">ESTATUS</th>
                                        <th style="width:35%;" scope="col">COMENTARIOS</th>
                                        <th style="width:15px !important;" >APROBADOR</th>
                                        <th style="width:15px !important;" >FECHA DE APROBACIÓN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="verdes">
                                        <td class="p-2 mb-2 text-white bg-info" style="font-size: 12px;" colspan="10">
                                            A.14.2 Seguridad en el desarrollo y en los procesos de
                                            soporte</td>
                                    </tr>

                                    @foreach ($gapda142s as $g142s)
                                        <tr>
                                            <th scope="row" style="width: 5%">
                                                {{ $g142s->anexo_indice }}
                                            </th>
                                            <td style="width:20%">
                                                {{ $g142s->anexo_politica }}
                                            </td>
                                            <td style="width:35%">
                                                {{ $g142s->anexo_descripcion }}
                                            </td>
                                            <td style="width:5%">
                                                <a href="#" data-type="select" data-pk="{{ $g142s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g142s->id) }}"
                                                    data-title="Seleccionar aplica"
                                                    data-value="{{ $g142s->aplica }}" class="aplica2"
                                                    data-name="aplica">
                                                </a>
                                            </td>

                                            <td class="text-justify">
                                                <a href="#" data-type="textarea" data-pk="{{ $g142s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g142s->id) }}"
                                                    data-title="Justificacion"
                                                    data-value="{{ $g142s->justificacion }}" class="justificacion"
                                                    data-name="justificacion">
                                                </a>
                                            </td>
                                            <td style="width:15%">
                                                <a href="#" data-type="select" data-pk="{{ $g142s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g142s->id) }}"
                                                    data-title="Seleccionar estatus" data-value="{{$g142s->estatus }}"
                                                    class="estatus" data-name="estatus" onchange='cambioOpciones();' id="opciones">
                                                </a>
                                            </td>
                                            <td>
                                                <a href="#" data-type="textarea" data-pk="{{ $g142s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g142s->id) }}"
                                                    data-title="Comentarios" data-value="{{ $g142s->comentarios }}"
                                                    class="comentarios" data-name="comentarios" >
                                                </a>
                                            </td>
                                            <td>
                                                Hola
                                            </td>
                                            <td style="width:15%" id="actualizacion_fecha_{{$g142s->id}}" >
                                                @if($g142s->estatus == 2 )
                                                {{$g142s->updated_at}}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive">

                            <table class="table" style="font-size: 12px;">
                                <thead class="thead-dark" align="center">
                                    <tr>
                                        <th scope="col" style="width: 5%">INDICE</th>
                                        <th style="min-width:400px" COLSPAN="2">CONTROL</th>
                                        <th scope="col" style="width: 5%">APLICA</th>
                                        <th style="min-width:200px;" scope="col">JUSTIFICACIÓN</th>
                                        <th style="width:15%;" scope="col">ESTATUS</th>
                                        <th style="width:35%;" scope="col">COMENTARIOS</th>
                                        <th style="width:15px !important;" >APROBADOR</th>
                                        <th style="width:15px !important;" >FECHA DE APROBACIÓN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="verdes">
                                        <td class="p-2 mb-2 text-white bg-info" style="font-size: 12px;" colspan="10">
                                            A.14.3 Datos de prueba</td>
                                    </tr>
                                    @foreach ($gapda143s as $g143s)
                                        <tr>
                                            <th scope="row" style="width: 5%">
                                                {{ $g143s->anexo_indice }}
                                            </th>
                                            <td style="width:20%">
                                                {{ $g143s->anexo_politica }}
                                            </td>
                                            <td style="width:35%">
                                                {{ $g143s->anexo_descripcion }}
                                            </td>
                                            <td style="width:5%">
                                                <a href="#" data-type="select" data-pk="{{ $g143s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g143s->id) }}"
                                                    data-title="Seleccionar aplica"
                                                    data-value="{{ $g143s->aplica }}" class="aplica2"
                                                    data-name="aplica">
                                                </a>
                                            </td>

                                            <td class="text-justify">
                                                <a href="#" data-type="textarea" data-pk="{{ $g143s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g143s->id) }}"
                                                    data-title="Justificacion"
                                                    data-value="{{ $g143s->justificacion }}" class="justificacion"
                                                    data-name="justificacion">
                                                </a>
                                            </td>
                                            <td style="width:15%">
                                                <a href="#" data-type="select" data-pk="{{ $g143s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g143s->id) }}"
                                                    data-title="Seleccionar estatus" data-value="{{$g143s->estatus }}"
                                                    class="estatus" data-name="estatus" onchange='cambioOpciones();' id="opciones">
                                                </a>
                                            </td>
                                            <td>
                                                <a href="#" data-type="textarea" data-pk="{{ $g143s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g143s->id) }}"
                                                    data-title="Comentarios" data-value="{{ $g143s->comentarios }}"
                                                    class="comentarios" data-name="comentarios" >
                                                </a>
                                            </td>
                                            <td>
                                                Hola
                                            </td>
                                            <td style="width:15%" id="actualizacion_fecha_{{$g143s->id}}" >
                                                @if($g143s->estatus == 2 )
                                                {{$g143s->updated_at}}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive">

                            <table class="table" style="font-size: 12px;">
                                <thead class="thead-dark" align="center">
                                    <tr>
                                        <th scope="col" style="width: 5%">INDICE</th>
                                        <th style="min-width:400px" COLSPAN="2">CONTROL</th>
                                        <th scope="col" style="width: 5%">APLICA</th>
                                        <th style="min-width:200px;" scope="col">JUSTIFICACIÓN</th>
                                        <th style="width:15%;" scope="col">ESTATUS</th>
                                        <th style="width:35%;" scope="col">COMENTARIOS</th>
                                        <th style="width:15px !important;" >APROBADOR</th>
                                        <th style="width:15px !important;" >FECHA DE APROBACIÓN</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr class="verdes">
                                        <td class="p-2 mb-2 text-white bg-info" style="font-size: 12px;" colspan="10">
                                            A.15 Relación con los proveedores</td>
                                    </tr>
                                    <tr class="verdes">
                                        <td class="p-2 mb-2 text-white bg-info" style="font-size: 12px;" colspan="10">
                                            A.15.1 Requisitos de seguridad en sistemas de información
                                        </td>
                                    </tr>
                                    @foreach ($gapda151s as $g151s)
                                        <tr>
                                            <th scope="row" style="width: 5%">
                                                {{ $g151s->anexo_indice }}
                                            </th>
                                            <td style="width:20%">
                                                {{ $g151s->anexo_politica }}
                                            </td>
                                            <td style="width:35%">
                                                {{ $g151s->anexo_descripcion }}
                                            </td>
                                            <td style="width:5%">
                                                <a href="#" data-type="select" data-pk="{{ $g151s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g151s->id) }}"
                                                    data-title="Seleccionar aplica"
                                                    data-value="{{ $g151s->aplica }}" class="aplica2"
                                                    data-name="aplica">
                                                </a>
                                            </td>

                                            <td class="text-justify">
                                                <a href="#" data-type="textarea" data-pk="{{ $g151s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g151s->id) }}"
                                                    data-title="Justificacion"
                                                    data-value="{{ $g151s->justificacion }}" class="justificacion"
                                                    data-name="justificacion">
                                                </a>
                                            </td>
                                            <td style="width:15%">
                                                <a href="#" data-type="select" data-pk="{{ $g151s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g151s->id) }}"
                                                    data-title="Seleccionar estatus" data-value="{{$g151s->estatus }}"
                                                    class="estatus" data-name="estatus" onchange='cambioOpciones();' id="opciones">
                                                </a>
                                            </td>
                                            <td class="text-justify">
                                                <a href="#" data-type="textarea" data-pk="{{ $g151s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g151s->id) }}"
                                                    data-title="Comentarios" data-value="{{ $g151s->comentarios }}"
                                                    class="comentarios" data-name="comentarios" >
                                                </a>
                                            </td>
                                            <td>
                                                Hola
                                            </td>
                                            <td style="width:15%" id="actualizacion_fecha_{{$g151s->id}}" >
                                                @if($g151s->estatus == 2 )
                                                {{$g151s->updated_at}}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive">

                            <table class="table" style="font-size: 12px;">
                                <thead class="thead-dark" align="center">
                                    <tr>
                                        <th scope="col" style="width: 5%">INDICE</th>
                                        <th style="min-width:400px" COLSPAN="2">CONTROL</th>
                                        <th scope="col" style="width: 5%">APLICA</th>
                                        <th style="min-width:200px;" scope="col">JUSTIFICACIÓN</th>
                                        <th style="width:15%;" scope="col">ESTATUS</th>
                                        <th style="width:35%;" scope="col">COMENTARIOS</th>
                                        <th style="width:15px !important;" >APROBADOR</th>
                                        <th style="width:15px !important;" >FECHA DE APROBACIÓN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="verdes">
                                        <td class="p-2 mb-2 text-white bg-info" style="font-size: 12px;" colspan="10">
                                            A.15.2 Gestión de la provisión de servicios del proveedor
                                        </td>
                                    </tr>
                                    @foreach ($gapda152s as $g152s)
                                        <tr>
                                            <th scope="row" style="width: 5%">
                                                {{ $g152s->anexo_indice }}
                                            </th>
                                            <td style="width:20%">
                                                {{ $g152s->anexo_politica }}
                                            </td>
                                            <td style="width:35%">
                                                {{ $g152s->anexo_descripcion }}
                                            </td>
                                            <td style="width:5%">
                                                <a href="#" data-type="select" data-pk="{{ $g152s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g152s->id) }}"
                                                    data-title="Seleccionar aplica"
                                                    data-value="{{ $g152s->aplica }}" class="aplica2"
                                                    data-name="aplica">
                                                </a>
                                            </td>

                                            <td class="text-justify">
                                                <a href="#" data-type="textarea" data-pk="{{ $g152s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g152s->id) }}"
                                                    data-title="Justificacion"
                                                    data-value="{{ $g152s->justificacion }}" class="justificacion"
                                                    data-name="justificacion">
                                                </a>
                                            </td>
                                            <td style="width:15%">
                                                <a href="#" data-type="select" data-pk="{{ $g152s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g152s->id) }}"
                                                    data-title="Seleccionar estatus" data-value="{{$g152s->estatus }}"
                                                    class="estatus" data-name="estatus" onchange='cambioOpciones();' id="opciones">
                                                </a>
                                            </td>
                                            <td class="text-justify">
                                                <a href="#" data-type="textarea" data-pk="{{ $g152s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g152s->id) }}"
                                                    data-title="Comentarios" data-value="{{ $g152s->comentarios }}"
                                                    class="comentarios" data-name="comentarios" >
                                                </a>
                                            </td>
                                            <td>
                                                Hola
                                            </td>
                                            <td style="width:15%" id="actualizacion_fecha_{{$g152s->id}}" >
                                                @if($g152s->estatus == 2 )
                                                {{$g152s->updated_at}}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive">

                            <table class="table" style="font-size: 12px;">
                                <thead class="thead-dark" align="center">
                                    <tr>
                                        <th scope="col" style="width: 5%">INDICE</th>
                                        <th style="width:55%" COLSPAN="2">CONTROL</th>
                                        <th scope="col" style="width: 5%">APLICA</th>
                                        <th style="min-width:200px;" scope="col">JUSTIFICACIÓN</th>
                                        <th style="width:15%;" scope="col">ESTATUS</th>
                                        <th style="width:35%;" scope="col">COMENTARIOS</th>
                                        <th style="width:15px !important;" >APROBADOR</th>
                                        <th style="width:15px !important;" >FECHA DE APROBACIÓN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="verdes">
                                        <td class="p-2 mb-2 text-white bg-info" style="font-size: 12px;" colspan="8">
                                            A.16 Gestión de incidentes de Seguridad de la Información
                                        </td>
                                    </tr>
                                    <tr class="verdes">
                                        <td class="p-2 mb-2 text-white bg-info" style="font-size: 12px;" colspan="8">
                                            A.16.1 Gestión de incidentes de Seguridad de la Información
                                            y mejoras</td>
                                    </tr>
                                    @foreach ($gapda161s as $g161s)
                                        <tr>
                                            <th scope="row" style="width: 5%">
                                                {{ $g161s->anexo_indice }}
                                            </th>
                                            <td style="width:20%">
                                                {{ $g161s->anexo_politica }}
                                            </td>
                                            <td style="width:35%">
                                                {{ $g161s->anexo_descripcion }}
                                            </td>
                                            <td style="width:5%">
                                                <a href="#" data-type="select" data-pk="{{ $g161s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g161s->id) }}"
                                                    data-title="Seleccionar aplica"
                                                    data-value="{{ $g161s->aplica }}" class="aplica2"
                                                    data-name="aplica">
                                                </a>
                                            </td>

                                            <td class="text-justify">
                                                <a href="#" data-type="textarea" data-pk="{{ $g161s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g161s->id) }}"
                                                    data-title="Justificacion"
                                                    data-value="{{ $g161s->justificacion }}" class="justificacion"
                                                    data-name="justificacion">
                                                </a>
                                            </td>
                                            <td style="width:15%">
                                                <a href="#" data-type="select" data-pk="{{ $g161s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g161s->id) }}"
                                                    data-title="Seleccionar estatus" data-value="{{$g161s->estatus }}"
                                                    class="estatus" data-name="estatus" onchange='cambioOpciones();' id="opciones">
                                                </a>
                                            </td>
                                            <td class="text-justify">
                                                <a href="#" data-type="textarea" data-pk="{{ $g161s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g161s->id) }}"
                                                    data-title="Comentarios" data-value="{{ $g161s->comentarios }}"
                                                    class="comentarios" data-name="comentarios" >
                                                </a>
                                            </td>
                                            <td>
                                                Hola
                                            </td>
                                            <td style="width:15%" id="actualizacion_fecha_{{$g161s->id}}" >
                                                @if($g161s->estatus == 2 )
                                                {{$g161s->updated_at}}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive">

                            <table class="table" style="font-size: 12px;">
                                <thead class="thead-dark" align="center">
                                    <tr>
                                        <th scope="col" style="width: 5%">INDICE</th>
                                        <th style="min-width:400px" COLSPAN="2">CONTROL</th>
                                        <th scope="col" style="width: 5%">APLICA</th>
                                        <th style="min-width:200px;" scope="col">JUSTIFICACIÓN</th>
                                        <th style="width:15%;" scope="col">ESTATUS</th>
                                        <th style="width:35%;" scope="col">COMENTARIOS</th>
                                        <th style="width:15px !important;" >APROBADOR</th>
                                        <th style="width:15px !important;" >FECHA DE APROBACIÓN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="verdes">
                                        <td class="p-2 mb-2 text-white bg-info" style="font-size: 12px;" colspan="10">
                                            A.17 Aspectos de seguridad de la información para la gestión
                                            de la continuidad del Instituto</td>
                                    </tr>
                                    <tr class="verdes">
                                        <td class="p-2 mb-2 text-white bg-info" style="font-size: 12px;" colspan="8">
                                            A.17.1 Continuidad de la Seguridad de la Información</td>
                                    </tr>
                                    @foreach ($gapda171s as $g171s)
                                        <tr>
                                            <th scope="row" style="width: 5%">
                                                {{ $g171s->anexo_indice }}
                                            </th>
                                            <td style="width:20%">
                                                {{ $g171s->anexo_politica }}
                                            </td>
                                            <td style="width:35%">
                                                {{ $g171s->anexo_descripcion }}
                                            </td>
                                            <td style="width:5%">
                                                <a href="#" data-type="select" data-pk="{{ $g171s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g171s->id) }}"
                                                    data-title="Seleccionar aplica"
                                                    data-value="{{ $g171s->aplica }}" class="aplica2"
                                                    data-name="aplica">
                                                </a>
                                            </td>

                                            <td class="text-justify">
                                                <a href="#" data-type="textarea" data-pk="{{ $g171s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g171s->id) }}"
                                                    data-title="Justificacion"
                                                    data-value="{{ $g171s->justificacion }}" class="justificacion"
                                                    data-name="justificacion">
                                                </a>
                                            </td>
                                            <td style="width:15%">
                                                <a href="#" data-type="select" data-pk="{{ $g171s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g171s->id) }}"
                                                    data-title="Seleccionar estatus" data-value="{{$g171s->estatus }}"
                                                    class="estatus" data-name="estatus" onchange='cambioOpciones();' id="opciones">
                                                </a>
                                            </td>
                                            <td class="text-justify">
                                                <a href="#" data-type="textarea" data-pk="{{ $g171s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g171s->id) }}"
                                                    data-title="Comentarios" data-value="{{ $g171s->comentarios }}"
                                                    class="comentarios" data-name="comentarios" >
                                                </a>
                                            </td>
                                            <td>
                                                Hola
                                            </td>
                                            <td style="width:15%" id="actualizacion_fecha_{{$g171s->id}}" >
                                                @if($g171s->estatus == 2 )
                                                {{$g171s->updated_at}}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive">

                            <table class="table" style="font-size: 12px;">
                                <thead class="thead-dark" align="center">
                                    <tr>
                                        <th scope="col" style="width: 5%">INDICE</th>
                                        <th style="min-width:400px" COLSPAN="2">CONTROL</th>
                                        <th scope="col" style="width: 5%">APLICA</th>
                                        <th style="min-width:200px;" scope="col">JUSTIFICACIÓN</th>
                                        <th style="width:15%;" scope="col">ESTATUS</th>
                                        <th style="width:35%;" scope="col">COMENTARIOS</th>
                                        <th style="width:15px !important;" >APROBADOR</th>
                                        <th style="width:15px !important;" >FECHA DE APROBACIÓN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="verdes">
                                        <td class="p-2 mb-2 text-white bg-info" style="font-size: 12px;" colspan="10">
                                            A.17.2 Redundancias</td>
                                    </tr>

                                    @foreach ($gapda172s as $g172s)
                                        <tr>
                                            <th scope="row" style="width: 5%">
                                                {{ $g172s->anexo_indice }}
                                            </th>
                                            <td style="width:20%">
                                                {{ $g172s->anexo_politica }}
                                            </td>
                                            <td style="width:35%">
                                                {{ $g172s->anexo_descripcion }}
                                            </td>
                                            <td style="width:5%">
                                                <a href="#" data-type="select" data-pk="{{ $g172s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g172s->id) }}"
                                                    data-title="Seleccionar aplica"
                                                    data-value="{{ $g172s->aplica }}" class="aplica2"
                                                    data-name="aplica">
                                                </a>
                                            </td>

                                            <td class="text-justify">
                                                <a href="#" data-type="textarea" data-pk="{{ $g172s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g172s->id) }}"
                                                    data-title="Justificacion"
                                                    data-value="{{ $g172s->justificacion }}" class="justificacion"
                                                    data-name="justificacion">
                                                </a>
                                            </td>
                                            <td style="width:15%">
                                                <a href="#" data-type="select" data-pk="{{ $g172s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g72s->id) }}"
                                                    data-title="Seleccionar estatus" data-value="{{$g172s->estatus }}"
                                                    class="estatus" data-name="estatus" onchange='cambioOpciones();' id="opciones">
                                                </a>
                                            </td>
                                            <td class="text-justify">
                                                <a href="#" data-type="textarea" data-pk="{{ $g172s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g172s->id) }}"
                                                    data-title="Comentarios" data-value="{{ $g172s->comentarios }}"
                                                    class="comentarios" data-name="comentarios" >
                                                </a>
                                            </td>
                                            <td>
                                                Hola
                                            </td>
                                            <td style="width:15%" id="actualizacion_fecha_{{$g172s->id}}" >
                                                @if($g172s->estatus == 2 )
                                                {{$g172s->updated_at}}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive">

                            <table class="table" style="font-size: 12px;">
                                <thead class="thead-dark" align="center">
                                    <tr>
                                        <th scope="col" style="width: 5%">INDICE</th>
                                        <th style="min-width:400px" COLSPAN="2">CONTROL</th>
                                        <th scope="col" style="width: 5%">APLICA</th>
                                        <th style="min-width:200px;" scope="col">JUSTIFICACIÓN</th>
                                        <th style="width:15%;" scope="col">ESTATUS</th>
                                        <th style="width:35%;" scope="col">COMENTARIOS</th>
                                        <th style="width:15px !important;" >APROBADOR</th>
                                        <th style="width:15px !important;" >FECHA DE APROBACIÓN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="verdes">
                                        <td class="p-2 mb-2 text-white bg-info" style="font-size: 12px;" colspan="10">
                                            A.18 Cumplimiento</td>
                                    </tr>
                                    <tr class="verdes">
                                        <td class="p-2 mb-2 text-white bg-info" style="font-size: 12px;" colspan="10">
                                            A.18.1 Cumplimiento de los requisitos legales y
                                            contractuales</td>
                                    </tr>
                                    @foreach ($gapda181s as $g181s)
                                        <tr>
                                            <th scope="row" style="width: 5%">
                                                {{ $g181s->anexo_indice }}
                                            </th>
                                            <td style="width:20%">
                                                {{ $g181s->anexo_politica }}
                                            </td>
                                            <td style="width:35%">
                                                {{ $g181s->anexo_descripcion }}
                                            </td>
                                            <td style="width:5%">
                                                <a href="#" data-type="select" data-pk="{{ $g181s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g181s->id) }}"
                                                    data-title="Seleccionar aplica"
                                                    data-value="{{ $g181s->aplica }}" class="aplica2"
                                                    data-name="aplica">
                                                </a>
                                            </td>

                                            <td class="text-justify">
                                                <a href="#" data-type="textarea" data-pk="{{ $g181s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g181s->id) }}"
                                                    data-title="Justificacion"
                                                    data-value="{{ $g181s->justificacion }}" class="justificacion"
                                                    data-name="justificacion">
                                                </a>
                                            </td>
                                            <td style="width:15%">
                                                <a href="#" data-type="select" data-pk="{{ $g181s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g181s->id) }}"
                                                    data-title="Seleccionar estatus" data-value="{{$g181s->estatus }}"
                                                    class="estatus" data-name="estatus" onchange='cambioOpciones();' id="opciones">
                                                </a>
                                            </td>
                                            <td class="text-justify">
                                                <a href="#" data-type="textarea" data-pk="{{ $g181s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g81s->id) }}"
                                                    data-title="Comentarios" data-value="{{ $g181s->comentarios }}"
                                                    class="comentarios" data-name="comentarios" >
                                                </a>
                                            </td>
                                            <td>
                                                Hola
                                            </td>
                                            <td style="width:15%" id="actualizacion_fecha_{{$g181s->id}}" >
                                                @if($g181s->estatus == 2 )
                                                {{$g181s->updated_at}}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive">

                            <table class="table" style="font-size: 12px;">
                                <thead class="thead-dark" align="center">
                                    <tr>
                                        <th scope="col" style="width: 5%">INDICE</th>
                                        <th style="min-width:400px" COLSPAN="2">CONTROL</th>
                                        <th scope="col" style="width: 5%">APLICA</th>
                                        <th style="min-width:200px;" scope="col">JUSTIFICACIÓN</th>
                                        <th style="width:15%;" scope="col">ESTATUS</th>
                                        <th style="width:35%;" scope="col">COMENTARIOS</th>
                                        <th style="width:15px !important;" >APROBADOR</th>
                                        <th style="width:15px !important;" >FECHA DE APROBACIÓN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="verdes">
                                        <td class="p-2 mb-2 text-white bg-info" style="font-size: 12px;" colspan="10">
                                            A.18.2 Revisiones de la Seguridad de la Información</td>
                                    </tr>
                                    @foreach ($gapda182s as $g182s)
                                        <tr>
                                            <th scope="row" style="width: 5%">
                                                {{ $g182s->anexo_indice }}
                                            </th>
                                            <td style="width:20%">
                                                {{ $g182s->anexo_politica }}
                                            </td>
                                            <td style="width:35%">
                                                {{ $g182s->anexo_descripcion }}
                                            </td>
                                            <td style="width:5%">
                                                <a href="#" data-type="select" data-pk="{{ $g182s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g182s->id) }}"
                                                    data-title="Seleccionar aplica"
                                                    data-value="{{ $g182s->aplica }}" class="aplica2"
                                                    data-name="aplica">
                                                </a>
                                            </td>
                                            <td class="text-justify">
                                                <a href="#" data-type="textarea" data-pk="{{ $g182s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g132s->id) }}"
                                                    data-title="Justificacion"
                                                    data-value="{{ $g132s->justificacion }}" class="justificacion"
                                                    data-name="justificacion">
                                                </a>
                                            </td>
                                            <td style="width:15%">
                                                <a href="#" data-type="select" data-pk="{{ $g182s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g182s->id) }}"
                                                    data-title="Seleccionar estatus" data-value="{{$g182s->estatus }}"
                                                    class="estatus" data-name="estatus" onchange='cambioOpciones();' id="opciones">
                                                </a>
                                            </td>
                                            <td>
                                                <a href="#" data-type="textarea" data-pk="{{ $g182s->id }}"
                                                    data-url="{{ route('admin.declaracion-aplicabilidad.update', $g182s->id) }}"
                                                    data-title="Comentarios" data-value="{{ $g182s->comentarios }}"
                                                    class="comentarios" data-name="comentarios" >
                                                </a>
                                            </td>
                                            <td>
                                                Hola
                                            </td>
                                            <td style="width:15%" id="actualizacion_fecha_{{$g182s->id}}" >
                                                @if($g182s->estatus == 2 )
                                                {{$g182s->updated_at}}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-2 col">
                            <button url="{{ route('admin.declaracion-aplicabilidad.descargar') }}"
                                onclik="generarReporte()" class="btn btn-sm btn-outline-primary generar-reporte">
                                <i class="mr-1 fas fa-print"></i>
                                Generar Reporte
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
