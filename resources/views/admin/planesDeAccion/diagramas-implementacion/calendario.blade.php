<div class="cardCalendario" style="box-shadow: none; !important">
    <div class="card-body" style="height: 658px;">
        <div id='calendar'></div>
    </div>
</div>

@section('scripts')
    @parent
    <script src="{{ asset('../js/calendario-fullcalendar/index.global.js') }}"></script>
    <script src="{{ asset('../js/calendario-fullcalendar/locales/locales-all.global.js') }}"></script>

    <script>
        var calendar;
        $(document).ready(function() {
            //initCalendar();
        });

        function initCalendar() {
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('admin.planes-de-accion.loadProject', $planImplementacion) }}",
                success: function(response) {
                    renderCalendar(response);
                }
            });
        }
        let eventsCalendar = [];

        function renderCalendar(response) {
            const mapStatusToColor = {
                "STATUS_ACTIVE": "#ecde00",
                "STATUS_DONE": "#17d300",
                "STATUS_FAILED": "#e10000",
                "STATUS_SUSPENDED": "#e7e7e7",
                "STATUS_UNDEFINED": "#00b1e1"
            };

            const mapStatusToEstatus = {
                "STATUS_ACTIVE": "En progreso",
                "STATUS_DONE": "Completado",
                "STATUS_FAILED": "Con retraso",
                "STATUS_SUSPENDED": "Suspendida",
                "STATUS_UNDEFINED": "Sin iniciar"
            };

            response.tasks.forEach(item => {
                // Destructuramos el objeto para obtener los valores específicos
                const {
                    id,
                    name,
                    progress,
                    status,
                    start,
                    duration,
                    end,
                    color
                } = item;

                const jsonEvents = {
                    id: id,
                    title: name,
                    color: mapStatusToColor[status] || "#00b1e1",
                    start: start,
                    end: end,
                    extendedProps: {
                        status: mapStatusToEstatus[status]
                    }
                };

                eventsCalendar.push(jsonEvents);
            });

            var calendarEl = document.getElementById('calendar');
            calendar = new FullCalendar.Calendar(calendarEl, {
                expandRows: true,
                locale: 'es',
                slotMinTime: '09:00',
                slotMaxTime: '19:00',
                height: '100%',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                initialView: 'dayGridMonth',
                initialDate: obtenerFechaActual(),
                navLinks: false, // can click day/week names to navigate views
                editable: false,
                selectable: false,
                nowIndicator: true,
                dayMaxEvents: true, // allow "more" link when too many events
                eventDidMount: function(info) {
                    $(info.el).popover({
                        title: info.event.title,
                        placement: 'top',
                        trigger: 'hover',
                        content: '<div style="font-family: Arial, sans-serif; font-size: 14px; padding: 5px;">' +
                            '<p><strong>Estado:</strong> ' + info.event.extendedProps.status + '</p>' +
                            '<p><strong>Fecha inicial:</strong> ' + convertirFecha(info.event.start) +
                            '</p>' +
                            '<p><strong>Fecha final:</strong> ' + convertirFecha(info.event.end) +
                            '</p>' +
                            '</div>',
                        container: 'body',
                        html: true
                    });
                },
                events: eventsCalendar,
                eventClick: function(info) {
                    alert('Event: ' + info.event.title);
                    alert('Coordinates: ' + info.jsEvent.pageX + ',' + info.jsEvent.pageY);
                    alert('View: ' + info.view.type);

                    // change the border color just for fun
                    info.el.style.borderColor = 'red';
                },
                dateClick: function(arg) {
                    console.log(arg.date.toUTCString()); // use *UTC* methods on the native Date Object
                    // will output something like 'Sat, 01 Sep 2018 00:00:00 GMT'
                }
            });

        }

        function renderCaleendar() {
            const tiempoEspera = 300;
            setTimeout(() => {

                calendar.render();
                calendar.setOption('locale', 'es');
                console.log('ejecutado');
            }, tiempoEspera);
        }

        function convertirFecha(cadenaFecha) {
            // Crear un objeto de fecha a partir de la cadena
            var fecha = new Date(cadenaFecha);

            // Obtener los componentes de la fecha
            var dia = fecha.getDate();
            var mes = fecha.getMonth() + 1; // Los meses van de 0 a 11, por lo que sumamos 1
            var año = fecha.getFullYear();

            // Asegurarnos de que los valores tengan dos dígitos (por ejemplo, '05' en lugar de '5')
            dia = (dia < 10) ? '0' + dia : dia;
            mes = (mes < 10) ? '0' + mes : mes;

            // Formatear la fecha como 'dd/mm/aaaa'
            var fechaFormateada = dia + '/' + mes + '/' + año;

            // Retornar la fecha formateada
            return fechaFormateada;
        }

        function obtenerFechaActual() {
            // Obtener la fecha actual
            const fechaActual = new Date();

            // Formatear la fecha en el formato deseado (por ejemplo, YYYY-MM-DD)
            const dia = String(fechaActual.getDate()).padStart(2, '0');
            const mes = String(fechaActual.getMonth() + 1).padStart(2,
                '0'); // El mes es devuelto de 0 a 11, por eso se suma 1
            const anio = fechaActual.getFullYear();

            // Retornar la fecha formateada
            return `${anio}-${mes}-${dia}`;
        }
    </script>
@endsection
