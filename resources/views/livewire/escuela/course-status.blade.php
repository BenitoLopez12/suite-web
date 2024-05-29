<div class="d-flex" style="gap: 20px;">
    <style>
        .curso-progreso-barra {
            height: 10px;
            border-radius: 100px;
            background-color: #E2E2E2;
            margin-top: 6px;
            position: relative;
        }

        .indicador-progreso-barra {
            position: absolute;
            background-color: #006DDB;
            border-radius: 100px;
            height: 100%;
        }

        .circulo {
            width: 60px;
            height: 60px;
        }

        .circulo img {
            width: 60px;
            /* Ajusta la imagen al tamaño del div circular */
            height: 60px;
            border-radius: 50%;
        }
    </style>

    <div style="width: 100%; ">
        <div style="position: sticky; top:80px;">
            {{-- <h5 class="col-12 titulo_general_funcion">Mis Cursos</h5> --}}
            <!--Para que me traiga correctamente el video hay que agregar -->
            <div>
                @if ($current && $current->iframe)
                    <div>
                        {!! $current->iframe !!}
                    </div>
                @else
                    <p>Sin registro</p>
                @endif
            </div>

            <div class="row" style="margin-top: 36px;">
                <div class="col-md-6">
                    @if ($current)
                        <h4>{{ $current->name }}</h4>
                    @else
                        <p>No current data available</p>
                    @endif
                </div>
                <div class="col-md-6">
                    <div class="cursor-pointer d-flex justify-content-end align-items-center" wire:click="completed"
                        style="cursor: pointer;">
                        @if ($current->completed)
                            <h4 class="mr-2 text-primary">Lección terminada</h4>
                            <i class="d-inline fas fa-toggle-on"
                                style="font-size: 30px; color: #006DDB; cursor: pointer;"></i>
                        @else
                            <h4 class="mr-2">Marcar esta lección como terminada</h4>
                            <i class="text-2xl text-gray-600 fas fa-toggle-off"
                                style="font-size: 30px; cursor: pointer;"></i>
                        @endif
                    </div>
                </div>
            </div>

            <div class="mt-2 card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            @if ($this->previous)
                                <a wire:click="changeLesson({{ $this->previous }}, 'previous')" class=" text-primary"
                                    style="cursor: pointer;">
                                    < Tema anterior </a>
                                    @else
                                        <a href="#" id="test" class="text-muted">
                                            < Tema anterior</a>
                            @endif
                            <div wire:target="changeLesson({{ $this->previous }})">
                            </div>
                        </div>
                        <div class="col-6 d-flex justify-content-end">
                            @if ($this->next)
                                <a wire:click="changeLesson({{ $this->next }})" class="text-primary"
                                    style="cursor: pointer;">
                                    Siguiente tema >
                                </a>
                            @else
                                <a href="#" id="test" class="text-muted"> Siguiente tema > </a>
                            @endif
                            <div wire:target="changeLesson({{ $this->next }})">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                @if ($current->resource)
                    <div class="flex text-gray-600 cursor-pointer item-center" wire:click="download"
                        style="cursor: pointer;">
                        <i class="text-lg fas fa-download d-inline"></i>
                        <p class="ml-2 text-sm d-inline">Descargar Recurso</p>
                    </div>
                @endif
            </div>


        </div>
    </div>

    <div class="card card-body" style="width: 320px;">
        <h4>{{ $course->title }}</h6>
            <div class="d-flex align-items-start">
                <div class="circulo">
                    <img src="{{ asset('img/avatars/escuela-instructor.png') }}">
                </div>
                <div>
                    <p class="ml-2">{{ $course->teacher->name }}</p>
                    <p class="ml-2" style="color: #E3A008;">{{ strtoupper($course->category->name) }}</p>

                </div>
            </div>

            <div class="caja-info-card-mc">
                <p class="mt-2 text-primary">{{ $this->advance . '%' }} completado</p>
                <div class="curso-progreso-barra">
                    <div class="indicador-progreso-barra" style="width: {{ $this->advance . '%' }};"></div>
                </div>
            </div>
            <div class="relative pt-1">
                <div class="flex h-2 mb-4 overflow-hidden text-xs bg-gray-200 rounded">
                    <div style="width:{{ $this->advance . '%' }}"
                        class="flex flex-col justify-center text-center text-white transition-all duration-500 bg-blue-500 shadow-none whitespace-nowrap">
                    </div>
                </div>
            </div>

            <ul style="list-style: none; cursor: pointer;">
                @foreach ($course->sections as $section)
                    <li>
                        <i style="font-size:10pt; cursor: pointer;" class="d-inline text-black-500 fas fa-play-circle">
                        </i>
                        <a class="inline mb-2 text-base font-bold">{{ $section->name }}</a>

                        <ul style="list-style: none;">
                            @foreach ($section->lessons as $lesson)
                                <li>
                                    <div>
                                        @if ($lesson->completed)
                                            @if ($current->id == $lesson->id)
                                                <span style="color:green;">
                                                    <a class="cursor:pointer;"
                                                        wire:click="changeLesson({{ $lesson }})">{{ $lesson->name }}</a>
                                                </span>
                                            @else
                                                <span style="color:rgb(0, 179, 0);">
                                                    <a class="cursor:pointer;"
                                                        wire:click="changeLesson({{ $lesson }})">{{ $lesson->name }}</a>
                                                </span>
                                            @endif
                                        @else
                                            @if ($current->id == $lesson->id)
                                                <span class="text-primary">
                                                    <a class="cursor:pointer;"
                                                        wire:click="changeLesson({{ $lesson }})">{{ $lesson->name }}</a>
                                                </span>
                                            @else
                                                <span class="">
                                                    <a class="cursor:pointer;"
                                                        wire:click="changeLesson({{ $lesson }})">{{ $lesson->name }}</a>
                                                </span>
                                            @endif
                                        @endif
                                    </div>
                                </li>
                            @endforeach

                            @foreach ($section->evaluations as $evaluation)
                                @php
                                    $totalLectionSection = $section->lessons->count();
                                    $completedLectionSection = $section->lessons->where('completed', true)->count();
                                @endphp
                                @if ($totalLectionSection != $completedLectionSection)
                                    <li style="list-style-type: disc;">
                                        <div>
                                            <span class="inline-block rounded-full border-2 border-gray-500"></span>
                                            <a class="cursor:pointer;"
                                                wire:click="alertSection()">{{ $evaluation->name }}
                                            </a>
                                        </div>
                                    </li>
                                @else
                                    @if ($evaluation->questions->count() > 0)
                                        @php
                                            $completed = in_array($evaluation->id, $evaluationsUser);
                                        @endphp
                                        <li style="list-style-type: disc;">
                                            <div>
                                                <span
                                                    class="inline-block rounded-full border-2 {{ $completed ? 'bg-green-500  border-green-500' : 'border-gray-500' }}"></span>
                                                <a class="cursor:pointer;"
                                                    href="{{ route('admin.curso.evaluacion', ['course' => $course->id, 'evaluation' => $evaluation->id]) }}"
                                                    wire:click="changeLesson({{ $lesson }})">{{ $evaluation->name }}
                                                </a>
                                            </div>
                                        </li>
                                    @endif
                                @endif
                            @endforeach
                        </ul>

                    </li>
                @endforeach
            </ul>
    </div>

    <script>
        document.querySelector('iframe').onload = function() {
            // Obtén el iframe por su ID
            var iframe = document.getElementById('iframe');

            // Accede al documento del iframe
            var iframeDoc = iframe.contentDocument || iframe.contentWindow.document;

            // Ahora puedes manipular el contenido del iframe como lo harías con el documento principal
            var elemento = iframeDoc.querySelector(
                '.html5-video-player .video-click-tracking, .html5-video-player .video-stream');

            console.log('from');

            elemento.addEventListener('ended', function() {
                // Envía una alerta cuando el video termine
                alert('El video ha terminado de reproducirse');
            });

        };
    </script>
    @section('scripts')
        <script>
            $(document).ready(function() {
                let videoVurso = $('iframe').contents().find('video.video-stream');
                console.log(videoVurso);
                videoVurso.on('ended', function() {
                    console.log('Video has ended!');
                });
            });
        </script>
    @endsection
</div>
