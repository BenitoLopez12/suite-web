@extends('layouts.admin')
@section('content')
    {{-- @can('planes_accion_access') --}}
    <style>
        @import url(https://fonts.googleapis.com/css?family=Muli:400, 300);

        .calendar,
        .calendar_weekdays,
        .calendar_content {
            max-width: 300px;
        }

        .calendar {
            margin: auto;
            font-family: 'Muli', sans-serif;
            font-weight: 400;
        }

        .calendar_content,
        .calendar_weekdays,
        .calendar_header {
            position: relative;
            overflow: hidden;
        }

        .calendar_weekdays div {
            display: inline-block;
            vertical-align: top;
        }

        .calendar_weekdays div,
        .calendar_content div {
            width: 14.28571%;
            overflow: hidden;
            text-align: center;
            background-color: transparent;
            color: #6f6f6f;
            font-size: 12px;
        }

        .calendar_content div {
            border: 1px solid transparent;
            float: left;
        }

        .calendar_content div:hover {
            border: 1px solid #dcdcdc;
            cursor: default;
        }

        .calendar_content div.blank:hover {
            cursor: default;
            border: 1px solid transparent;
        }

        .calendar_content div.past-date {
            color: #d5d5d5;
        }

        .calendar_content div.today {
            font-weight: bold;
            font-size: 12px;
            color: #1040dd;
            border: 1px solid #dcdcdc;
        }

        .calendar_content div.selected {
            background-color: #f0f0f0;
        }

        .calendar_header {
            width: 100%;
            text-align: center;
        }

        .calendar_header h2 {
            padding: 5px 10px;
            font-family: 'Muli', sans-serif;
            font-weight: 300;
            font-size: 12px;
            color: #1040dd;
            float: left;
            width: 70%;
            margin: 0 0 10px;
        }

        button.switch-month {
            background-color: transparent;
            padding: 0;
            outline: none;
            border: none;
            color: #dcdcdc;
            float: left;
            width: 15%;
            transition: color .2s;
        }

        button.switch-month:hover {
            color: #1040dd;
        }

    </style>
    <style>
        .c_main,
        .container-fluid {
            padding: 0 !important;
            padding-top: 0 !important;
        }

        .caja_btn_silent {
            position: relative;
        }

        .btn-silent {
            display: block;
            width: 100%;
            position: relative;
            color: #444 !important;
            text-decoration: underline;
            padding: 10px 0;
            cursor: pointer;
        }

        .btn-silent:before {
            content: "";
            position: absolute;
            width: 0%;
            height: 2px;
            bottom: 5px;
            background-color: #00abb2;
            transition: 0.3s;
            z-index: 1;
        }

        .btn-silent:after {
            content: "";
            position: absolute;
            width: 100%;
            height: 2px;
            bottom: 5px;
            background-color: #e6e6e6;
            transition: 0.4s;
            left: 0;
            z-index: 0;
        }

        .btn-silent:hover:before {
            width: 100%;
        }

        .btn-silent i {
            font-size: 15pt;
        }

        .btn-silent span {
            position: absolute;
            left: 50px;
        }

        .btn-silent:hover {
            color: #00abb2 !important;
        }

    </style>
    <style type="text/css">
        body {
            background-color: #fff !important;
        }

        .titulo-seccion {
            font-weight: bolder;
            font-size: 15pt;
            margin-bottom: 0px;
            color: #00abb2;
            border-bottom: 2px solid #ccc;
            padding-bottom: 7px;
            padding-left: 20px;
        }

        .titulo-seccion i {
            margin-left: -18px;
            font-size: 17pt;
        }


        .carousel-item {
            text-align: center;
            background-color: #f1f1f1;
        }

        .img_carrusel {
            height: 300px !important;
            opacity: 0.8;

            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: all;
        }

        .carousel-caption {
            z-index: 3;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
        }

        .carousel-inner h5 {
            text-shadow: 0px 0px 3px #000 !important;
            text-align: left;
            z-index: 1;
            background-color: rgba(255, 255, 255, 0.2);
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            padding: 7px;
            opacity: 0;
            transition: 0.2s;
            text-align: center;
        }

        .carousel-inner:hover h5 {
            opacity: 1;
        }

        .carousel-inner p {
            display: none;
        }

        .carousel-control-prev,
        .carousel-control-next {
            opacity: 1 !important;
            z-index: 3;
        }

        .carousel-indicators li {
            opacity: 1 !important;
        }

        .carousel-indicators li.active {
            opacity: 1 !important;
            background-color: #00abb2 !important;
        }


        .comunicado {
            display: flex;
            height: 200px;
            align-items: center;
            justify-content: space-between;
        }

        .comunicado {
            margin-top: 10px;
        }

        .img_comunicado {
            width: 33.3%;
            height: 200px;

            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: all;
        }

        .text_comunicado {
            width: calc(100% - 200px);
            padding: 0 20px;

        }

        .text_comunicado p {
            text-align: justify;
        }


        .doc_publicado {
            display: flex;
            align-items: center;
            position: relative;
            background-color: #f0f0f0;
            padding: 0px 20px;
            padding-top: 7px;
            box-sizing: border-box;
            border-radius: 7px;
        }

        .doc_publicado {
            margin-top: 20px;
        }

        .icon_doc {
            display: flex;
            align-items: center;
            width: 10%;
        }

        .icon_doc i {
            font-size: 50pt;
            color: #B30909;
            transition: 0.1s;
        }

        .icon_doc i:hover {
            transform: scale(1.1);
            filter: brightness(1.5);
        }

        .text_doc {
            width: 70%;
        }

        .text_doc h5 {
            font-weight: bold;
        }

        .opciones_doc {
            width: 20%;
        }

        .img_empleado {
            height: 40px;
            width: auto;
            clip-path: circle(20px at 50% 50%);
        }



        .cuadro_empleados {
            position: sticky;
            top: 56px;
            height: 600px;
            overflow-y: auto;
        }

        @media(max-with: 1000px) {
            .cuadro_empleados {
                position: relative !important;
                height: auto !important;
            }
        }


        .caja_nuevo {}

        .nuevo {
            text-align: center;
            background-color: #f3f3f3;
            border-left: 2px solid #00abb2;
            margin-top: 10px;
            padding: 10px;
        }

        .nombre_nuevo {
            font-size: 12pt;
            text-align: center;
            width: 100%;
            margin-top: 10px;
            font-weight: bold;
        }

        .img_nuevo {
            width: 100%;
            text-align: center;
        }

        .img_nuevo img {}

        .datos_nuevo {
            width: 100%;
        }

        .datos_nuevo h6 {
            margin: 0;
            font-weight: bold;
        }

        .datos_nuevo p {
            margin: 0;
            margin-bottom: 4px;
            line-height: 20px;
            margin-top: -5px;
        }

        .btn_link_agenda {
            all: unset;
            font-size: 11pt;
            color: #00abb2;
            cursor: pointer;
            transition: 0.09;
        }

        .btn_link_agenda:hover {
            transform: scale(1.1);
        }

    </style>


    <div class="card" style="box-shadow: none; background-color: transparent;">
        <div class="py-2 col-md-10 col-sm-9 card card-body bg-primary align-self-center "
            style="margin-top:0px !important; ">
            <h3 class="mb-2 text-center text-white"
                style="background: #00abb2;color: white !important;padding: 5px;border-radius: 8px;"><strong>Portal de
                    Comunicación </strong>
            </h3>
        </div>

        @include('partials.flashMessages')

        <div class="card-body">
            <div class="row">
                <div class="col-9">
                    <div class="row">
                        <div class="col-sm-12 col-12 col-lg-4">
                            <div class="p-2" id="clima"
                                style="border-left: solid 2px #00abb2; background-color: #e6e6e6;"></div>
                            <div class="p-3"
                                style=" margin-top: 20px; border-left: solid 2px #00abb2;  background-color: #f3f3f3;position: relative;">
                                <a href="{{ asset('admin/system-calendar') }}" class="btn_link_agenda"
                                    style=" position: absolute; top:3px; right:8px;" title="Agenda organizacional"><i
                                        class="fas fa-calendar-alt"></i></a>
                                <div class="calendar calendar-first" id="calendar_first" style="margin-top: 10px;">
                                    <div class="calendar_header">
                                        <button class="switch-month switch-left"> <i
                                                class="fa fa-chevron-left"></i></button>
                                        <h2></h2>
                                        <button class="switch-month switch-right"> <i
                                                class="fa fa-chevron-right"></i></button>
                                    </div>
                                    <div class="calendar_weekdays"></div>
                                    <div class="calendar_content"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-12 col-lg-8">
                            <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    {{-- <li data-target="#carouselExampleCaptions" data-slide-to=""
                                    class="active"></li> --}}
                                    @foreach ($comunicacionSgis_carrusel as $idx => $carrusel)
                                        <li data-target="#carouselExampleCaptions" data-slide-to="{{ $idx }}"
                                            class="{{ $idx == 0 ? 'active' : '' }}"></li>
                                    @endforeach
                                </ol>
                                <div class="carousel-inner">
                                    {{-- <div class="carousel-item active">
                                        <div class="img_carrusel" style="background-image: url('{{ asset('img/Carrusel_inicio.png') }}');">
                                        </div>
                                            <div class="carousel-caption d-none d-md-block">
                                            </div>
                                    </div> --}}
                                    @forelse($comunicacionSgis_carrusel as $idx=>$carrusel)
                                        @php
                                            if ($carrusel->first()->count()) {
                                                if ($carrusel->imagenes_comunicacion->first()) {
                                                    $imagen = 'storage/imagen_comunicado_SGI/' . $carrusel->imagenes_comunicacion->first()->imagen;
                                                }
                                            } else {
                                                $imagen = 'img/tabantaj_fondo_blanco.png';
                                            }

                                        @endphp
                                        <div class="carousel-item {{ $idx == 0 ? 'active' : '' }}">
                                            <div class="img_carrusel"
                                                style="background-image: url('{{ asset($imagen) }}');">
                                            </div>
                                            <div class="carousel-caption d-none d-md-block">
                                                <h5>{{ $carrusel->titulo }}</h5>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="carousel-item active">
                                            <div class="img_carrusel"
                                                style="background-image: url('{{ asset('img/Carrusel_inicio.png') }}');">
                                            </div>
                                            <div class="carousel-caption d-none d-md-block">
                                                <h5>Sin Comunicados</h5>
                                                <p></p>
                                            </div>
                                        </div>
                                    @endforelse
                                </div>



                                <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button"
                                    data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleCaptions" role="button"
                                    data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                        </div>
                        <div class="mt-5 col-lg-12">
                            <h2 class="titulo-seccion"><i class="mr-3 far fa-newspaper"></i>Comunicados</h2>
                            @forelse($comunicacionSgis as $comunicacionSgi)
                                <div class="comunicado" style="position:relative;">
                                    @php
                                        if ($comunicacionSgi->first()->count()) {
                                            if ($carrusel->imagenes_comunicacion->first()) {
                                                $imagen = 'storage/imagen_comunicado_SGI/' . $comunicacionSgi->imagenes_comunicacion->first()->imagen;
                                            }
                                        } else {
                                            $imagen = 'img/portal_404.png';
                                        }

                                    @endphp

                                    {{-- {{ asset('public/storage/imagen_comunicado_SGI/'. $comunicacionSgi->imagenes_comunicacion->first()->imagen) }} --}}

                                    <div class="img_comunicado" style="background-image: url('{{ asset($imagen) }}');">
                                    </div>
                                    <div class="text_comunicado">
                                        <h4 class="w-100">{{ $comunicacionSgi->titulo }}</h4>

                                        <div
                                            style="text-align:left !important; overflow:hidden; height:100px !important; background-color:#EEE; !important; padding:10px; display:block !important; justify-content:start !important;">
                                            {!! $comunicacionSgi->descripcion !!}
                                        </div>
                                        <a href="{{ asset('admin/comunicacion-sgis/' . $comunicacionSgi->id) }}">Leer
                                            más</a>
                                    </div>
                                </div>
                            @empty
                                <div class="comunicado" style="position:relative;">
                                    <div class="img_comunicado"
                                        style="background-image: url('{{ asset('img/portal_404.png') }}');"></div>
                                    <div class="text_comunicado">
                                        <h4 class="w-100">Sin comunicados que mostar</h4>
                                        <p class="w-100">

                                        </p>
                                        <a href=""></a>
                                    </div>
                                </div>
                            @endforelse
                            <h2 class="mt-5 titulo-seccion"><i class="mr-3 far fa-file-alt"></i>Documentos publicados </h2>
                            {{-- @foreach ($documentos_publicados as $documento)
                                <a href="{{ route('admin.documentos.renderViewDocument', $documento->id) }}"
                                    class="list-group-item cards text-dark">
                                    <i class="mr-1 fas fa-file-pdf text-danger"></i>
                                    {{ Str::limit($documento->codigo . ' - ' . $documento->nombre . '', 50, '...') }}
                                    <div>
                                        <span class="badge badge-dark"
                                            style="text-transform: capitalize">{{ $documento->tipo }}</span>
                                        @if ($documento->macroproceso_id)
                                            <span class="badge badge-primary"
                                                style="text-transform: capitalize">{{ $documento->macroproceso->nombre }}</span>
                                        @endif
                                        @if ($documento->proceso_id)
                                            <span class="badge badge-success"
                                                style="text-transform: capitalize">{{ $documento->proceso->nombre }}</span>
                                        @endif
                                    </div>
                                </a>
                            @endforeach --}}

                            @forelse($documentos_publicados as $documento)
                                <div class="doc_publicado">
                                    <div class="icon_doc">
                                        <a href="{{ route('admin.documentos.renderViewDocument', $documento->id) }}"
                                            title="Ver documento">
                                            <i class="fas fa-file-pdf"></i>
                                        </a>
                                    </div>
                                    <div class="text_doc">
                                        <h5>{{ Str::limit($documento->codigo . ' - ' . $documento->nombre . '', 50, '...') }}
                                        </h5>
                                        <p>
                                            Se ha publicado el documento {{ $documento->codigo }}
                                            {{ $documento->nombre }} el
                                            10/10/21.
                                        </p>
                                        <p>
                                            <span class="badge badge-dark"
                                                style="text-transform: capitalize">{{ $documento->tipo }}</span>
                                            @if ($documento->macroproceso_id)
                                                <span class="badge badge-primary"
                                                    style="text-transform: capitalize">{{ $documento->macroproceso->nombre }}</span>
                                            @endif
                                            @if ($documento->proceso_id)
                                                <span class="badge badge-success"
                                                    style="text-transform: capitalize">{{ $documento->proceso->nombre }}</span>
                                            @endif
                                            <span style="color:red; margin-left:20px;"><i class="fas fa-eye"></i>
                                                <strong>{{ $documento->no_vistas }}</strong></span>
                                        </p>
                                    </div>
                                    <div class="opciones_doc">
                                        <h6><strong>Responsable:</strong></h6>
                                        <img src="{{ asset('storage/empleados/imagenes/' . $documento->responsable->foto) }}"
                                            class="img_empleado" title="{{ $documento->responsable->name }}"><br />
                                        <a href="{{ route('admin.documentos.renderViewDocument', $documento->id) }}">Ver
                                            documento</a>
                                    </div>
                                </div>
                            @empty
                                <div class="comunicado" style="position:relative;">
                                    <div class="img_comunicado"
                                        style="background-image: url('{{ asset('img/no_docs.svg') }}'); transform: scale(0.8);">
                                    </div>
                                    <div class="text_comunicado">
                                        <h4 class="w-100">Sin documentos que mostar</h4>
                                        <p class="w-100">

                                        </p>
                                        <a href=""></a>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="row">
                        <div class="col-lg-12 caja_btn_silent">
                            <a class="btn-silent" href="{{ asset('admin/organizacions') }}"><i
                                    class="mr-2 fas fa-building"></i>
                                <span>Organización</span></a>
                            <a class="btn-silent" href="{{ asset('admin/sedes/organizacion') }}"><i
                                    class="mr-2 fas fa-map-marked-alt "></i> <span>Sedes</span></a>
                            <a href="{{ route('admin.areas.renderJerarquia') }}" class="btn-silent">
                                <i class="fab fa-adn iconos_menu mr-2"></i>
                                <span>Áreas</span>
                            </a>
                            <a href="{{ route('admin.procesos.mapa') }}" class="btn-silent">
                                <i class="fas fa-dice-d20 iconos_menu mr-2"></i>
                                <span> Mapa de procesos </span>
                            </a>
                            <a class="btn-silent" href="{{ asset('admin/organigrama') }}"><i
                                    class="mr-2 fas fa-sitemap"></i>
                                <span>Organigrama</span></a>
                            <a class="btn-silent" href="{{ asset('admin/directorio') }}"><i
                                    class=" mr-2 fas fa-address-book"></i> <span>Directorio</span></a>
                            <a class="btn-silent" href="{{ asset('admin/documentos/publicados') }}"><i
                                    class="mr-2 fas fa-folder"></i> <span>Documentos</span></a>
                            <a class="btn-silent" href="{{ asset('admin/politica-sgsis/visualizacion') }}"><i
                                    class="mr-2 fas fa-file"></i> <span>Política SGSI</span></a>
                            <a class="btn-silent" href="{{ asset('admin/comiteseguridads/visualizacion') }}"><i
                                    class="mr-2 fas fa-users"></i> <span>Comité del SGSI</span></a>

                            @if ($empleado_asignado)
                                <a class="btn-silent" href="{{ asset('admin/portal-comunicacion/reportes') }}"><i
                                        class="mr-2 fas fa-hand-paper"></i> <span>Reportar</span></a>
                            @endif

                        </div>
                        <div class="mt-5 col-lg-12">
                            <div class="cuadro_empleados scroll_estilo">
                                <h2 class="titulo-seccion"><i class="mr-3 far fa-user"></i>Nuevos ingresos</h2>
                                <div class="caja_nuevo">
                                    @forelse($nuevos as $nuevo)
                                        <div class="nuevo">
                                            <div class="img_nuevo">
                                                <img src="{{ asset('storage/empleados/imagenes/' . $nuevo->avatar) }}"
                                                    class="img_empleado">
                                            </div>
                                            <h5 class="nombre_nuevo">{{ $nuevo->name }}</h5>
                                            <div class="datos_nuevo">
                                                <p>{{ $nuevo->puesto }}<br>
                                                    @if (is_null($nuevo->area->area))
                                                        No hay Area
                                                    @else
                                                        {{ $nuevo->area->area }}
                                                    @endif
                                                </p>
                                                <h6 class="mt-3">Fecha de ingreso</h6>
                                                <span>{{ \Carbon\Carbon::parse($nuevo->antiguedad)->format('d-m-Y') }}</span>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="nuevo">No hay nuevos ingresos registrados en este mes.</div>
                                    @endforelse

                                </div>

                                <h2 class="mt-5 titulo-seccion"><i class="mr-3 fas fa-birthday-cake"></i>Cumpleaños</h2>
                                <div class="caja_nuevo">
                                    @forelse($cumpleaños as $cumple)
                                        <div class="nuevo">
                                            <div class="img_nuevo">
                                                @forelse($nuevos as $nuevo)
                                                    <img src="{{ asset('storage/empleados/imagenes/' . $nuevo->avatar) }}"
                                                        class="img_empleado">
                                                @empty
                                                    <div class="nuevo">No hay nuevos ingresos registrados en este
                                                        mes.</div>
                                                @endforelse
                                            </div>
                                            <h5 class="nombre_nuevo">{{ $cumple->name }}</h5>
                                            <div class="datos_nuevo">
                                                <p>{{ $cumple->puesto }}<br>
                                                    @if (is_null($cumple->area->area))
                                                        No hay Area
                                                    @else
                                                        {{ $cumple->area->area }}
                                                    @endif
                                                </p>
                                                <h6 class="mt-3">Fecha de cumpleaños</h6>
                                                @php
                                                    $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
                                                    $fecha = \Carbon\Carbon::createFromFormat('Y-m-d', $cumple->cumpleaños);
                                                    $mes = $meses[$fecha->format('n') - 1];
                                                    $inputs['Fecha'] = $fecha->format('d') . ' de ' . $mes;
                                                @endphp

                                                <span>{{ $inputs['Fecha'] }}</span>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="nuevo">No hay cumpleaños registrados en este mes.</div>
                                    @endforelse
                                </div>

                                <h2 class="mt-5 titulo-seccion"><i class="mr-3 fas fa-medal"></i>Aniversarios</h2>
                                <div class="caja_nuevo">
                                    <div class="caja_nuevo">
                                        @forelse($aniversarios as $aniversario)

                                            @if (\Carbon\Carbon::parse($aniversario->antiguedad)->format('Y') < $hoy->format('Y'))
                                                <div class="nuevo">
                                                    <div class="img_nuevo">
                                                        <img src="{{ asset('storage/empleados/imagenes/' . $nuevo->avatar) }}"
                                                            class="img_empleado">
                                                    </div>
                                                    <h5 class="nombre_nuevo">{{ $aniversario->name }}</h5>
                                                    <div class="datos_nuevo">
                                                        <p>{{ $aniversario->puesto }}<br>
                                                            @if (is_null($aniversario->area->area))
                                                                No hay Area
                                                            @else
                                                                {{ $aniversario->area->area }}
                                                            @endif
                                                        </p>
                                                        <h6 class="mt-3">Antigüedad</h6>
                                                        <span>{{ \Carbon\Carbon::createFromTimeStamp(strtotime($aniversario->antiguedad))->diffInYears() }}
                                                            año(s)
                                                        </span>
                                                    </div>
                                                </div>
                                            @endif
                                        @empty
                                            <div class="nuevo">No hay aniversarios registrados en este mes.</div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- @endcan --}}
@endsection
@section('scripts')
    <script src="{{ asset('js/calendar-comunicado.js') }}"></script>
    <script>
        /*SEARCH BY USING A CITY NAME (e.g. athens) OR A COMMA-SEPARATED CITY NAME ALONG WITH THE COUNTRY CODE (e.g. athens,gr)*/
        /*SUBSCRIBE HERE FOR API KEY: https://home.openweathermap.org/users/sign_up*/
        const apiKey = "4d8fb5b93d4af21d66a2948710284366";
        let city = 'Mexico';
        const url =
            `https://api.openweathermap.org/data/2.5/weather?q=${city}&appid=${apiKey}&units=metric&lang=es`;

        obtenerClima(url);

        async function obtenerClima(url) {
            let api = await fetch(url);
            let response = await api.json();
            let climaContenedor = document.getElementById('clima');
            const icon = `https://s3-us-west-2.amazonaws.com/s.cdpn.io/162656/${response.weather[0]["icon"]}.svg`;
            climaContenedor.innerHTML = `
            <p class="" style="text-align:left; margin:0;">
                <i class="fas fa-globe-americas" style="font-size:;"></i>
                ${response.name}
            </p>
            <div style="text-align:left; margin:0 ; display:inline-block;">
                <div style="font-size:7pt; width:100px; text-align:left; float:left;">
                    <img src="${icon}" style="width:40px; margin-top:-13px;">
                    <strong style="font-size: 27px;">${Math.ceil(response.main.temp)}</strong>
                    <span style="font-size:12px">°C</span>
                </div>
                <div style="font-size:7pt; width:90px; text-align:left; margin-top: 5px; float:left; text-transform: capitalize;">
                    <strong>${response.weather[0]["description"]}</strong> <br>
                    ${Math.ceil(response.main.temp_max)}<sup>°</sup>/
                    ${Math.ceil(response.main.temp_min)}<sup>°</sup>
                    Temp.${Math.ceil(response.main.feels_like)}<sup>°C</sup>
                </div>
            </div>
            `;
            console.log(response);
        }
    </script>
    <script src="{{ asset('js/calendario-comunicacion.js') }}"></script>
@endsection
