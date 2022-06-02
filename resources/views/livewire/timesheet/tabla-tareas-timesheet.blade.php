<div class="w-100">
    @php
        use App\Models\TimesheetHoras;
    @endphp
    <style type="text/css">
        .input_tarea{
            transition: 0.4s;
        }
    </style>
    @can('timesheet_administrador_tareas_proyectos_create')
        <form wire:submit.prevent="create()" class="form-group w-100">
            <div class="d-flex justify-content-center w-100">
                <div class="form-group w-100 mr-4 ">
                    <label><i class="fas fa-list iconos-crear"></i> Proyecto</label>
                    @if ($origen == 'tareas-proyectos')
                        <div class="form-control" style="background-color: #eee">{{ $proyecto_seleccionado->proyecto }}
                        </div>
                    @endif
                    @if ($origen == 'tareas')
                        <select class="mr-4 form-control" wire:model="proyecto_id" required>
                            <option selected value="">Seleccione proyecto al que pertenece</option>
                            @foreach ($proyectos as $proyecto)
                                <option value="{{ $proyecto->id }}">{{ $proyecto->proyecto }}</option>
                            @endforeach
                        </select>
                    @endif
                </div>
                <div class="form-group w-100 mr-4">
                    <label><i class="fas fa-list-alt iconos-crear"></i> Tarea Nueva</label>
                    <input class="form-control w-100 mr-4" placeholder="Nombre de la tarea" wire:model="tarea_name" required>
                </div>
                <div class="form-group" style="position:relative; min-width:150px;">
                    <button class="btn btn-success" style="position: absolute; bottom: 0;"><i class="fas fa-plus"></i>
                        Agregar</button>
                </div>
            </div>
        </form>
    @endcan
    <div class="datatable-fix w-100 mt-5">
        <table id="tabla_time_tareas" class="table w-100 tabla-animada tabla_time_tareas">
            <thead class="w-100">
                <tr>
                    <th>Tarea </th>
                    <th>Proyecto</th>
                    <th style="max-width: 150px; width: 150px;">Opciones</th>
                </tr>
            </thead>

            <tbody>
                @if ($origen == 'tareas')
                    @foreach ($tareas as $tarea)
                        <tr>
                            <td wire:ignore> <input class="input_tarea form-control" data-type="change" data-id="{{ $tarea->id }}" name="tarea" value="{{ $tarea->tarea }}"> </td>
                            <td> {{ $tarea->proyecto_id ? $tarea->proyecto->proyecto : '' }} </td>
                            <td>
                                @can('timesheet_administrador_tareas_proyectos_delete')
                                    @php
                                        $time_tarea = TimesheetHoras::where('tarea_id', $tarea->id)->exists();
                                    @endphp
                                    @if(!$time_tarea)
                                        <button class="btn" data-toggle="modal" data-target="#modal_tarea_eliminar_{{ $tarea->id}}" title="Eliminar">
                                            <i class="fas fa-trash-alt" style="color: red; font-size: 15pt;"></i>
                                        </button>
                                     @else
                                        <button class="btn" title="Esta tarea no puede ser eliminada debido a que está en uso">
                                                <i class="fas fa-trash-alt" style="color: #aaa; font-size: 15pt;"></i>
                                        </button>
                                    @endif
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                @endif

                @if ($origen == 'tareas-proyectos')
                    @foreach ($tareas_proyecto as $tarea)
                        <tr>
                            <td> <input class="input_tarea form-control" data-type="change" data-id="{{ $tarea->id }}" name="tarea" value="{{ $tarea->tarea }}"> </td>
                            <td> {{ $tarea->proyecto_id ? $tarea->proyecto->proyecto : '' }} </td>
                            <td>
                                @php
                                    $time_tarea = TimesheetHoras::where('tarea_id', $tarea->id)->exists();
                                @endphp
                                @if(!$time_tarea)
                                    <button class="btn" data-toggle="modal" data-target="#modal_tarea_eliminar_{{ $tarea->id}}" title="Eliminar">
                                        <i class="fas fa-trash-alt btn" style="color: red; font-size: 15pt;"></i>
                                    </button>
                                 @else
                                    <div class="btn">
                                            <i class="fas fa-trash-alt" style="color: #aaa; font-size: 15pt;" title="Esta tarea no puede ser eliminada debido a que está en uso"></i>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
    @if ($origen == 'tareas')
        @foreach ($tareas as $tarea)
            <div class="modal fade" id="modal_tarea_eliminar_{{ $tarea->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <button class="btn btn-tache-cerrar" data-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
                            <div class="delete">
                                <div class="text-center">
                                    <i class="fa-solid fa-trash-can" style="color: #E34F4F; font-size:60pt;"></i>
                                    <h1 class="my-4" style="font-size:14pt;">Eliminar Tarea: <small>{{ $tarea->tarea }}</small></h1>
                                    <p class="parrafo">¿Desea eliminar la tarea {{ $tarea->tarea }}?</p>
                                </div>
                                
                                <div class="mt-4 d-flex justify-content-between">
                                    <button class="btn btn_cancelar" data-dismiss="modal">
                                        Cancelar
                                    </button>
                                    <button class="btn btn-info" style="border:none; background-color:#E34F4F;"  wire:click="destroy({{ $tarea->id }})" data-dismiss="modal">
                                        Eliminar Tarea
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
    @if ($origen == 'tareas-proyectos')
        @foreach ($tareas_proyecto as $tarea)
            <div class="modal fade" id="modal_tarea_eliminar_{{ $tarea->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <button class="btn btn-tache-cerrar" data-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
                            <div class="delete">
                                <div class="text-center">
                                    <i class="fa-solid fa-trash-can" style="color: #E34F4F; font-size:60pt;"></i>
                                    <h1 class="my-4" style="font-size:14pt;">Eliminar Tarea: <small>{{ $tarea->tarea }}</small></h1>
                                    <p class="parrafo">¿Desea eliminar la tarea {{ $tarea->tarea }}?</p>
                                </div>
                                
                                <div class="mt-4 d-flex justify-content-between">
                                    <button class="btn btn_cancelar" data-dismiss="modal">
                                        Cancelar
                                    </button>
                                    <button class="btn btn-info" style="border:none; background-color:#E34F4F;"  wire:click="destroy({{ $tarea->id }})" data-dismiss="modal">
                                        Eliminar Tarea
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', ()=>{
            Livewire.on('scriptTabla', ()=>{
                tablaLivewire('tabla_time_tareas');
            });

            document.querySelector('.tabla_time_tareas').addEventListener('change', (e)=>{
                if (e.target.getAttribute('data-type') == 'change') {
                    let elemento = e.target;
                    let id = elemento.getAttribute('data-id');
                    let value = elemento.value;
                    @this.actualizarNameTarea(id, value);
                }
            });

            Livewire.on('tarea-actualizada', (tarea)=>{
                document.querySelector(`input[data-id="${tarea.id}"]`).style.border="1px solid #1FD02F";
                setTimeout(() => {
                    document.querySelector(`input[data-id="${tarea.id}"]`).style.border="1px solid #ccc";
                }, 1000);
                document.querySelector('.tabla_time_tareas').addEventListener('change', (e)=>{
                    if (e.target.getAttribute('data-type') == 'change') {
                        let elemento = e.target;
                        let id = elemento.getAttribute('data-id');
                        let value = elemento.value;
                        @this.actualizarNameTarea(id, value);
                    }
                });
            });
        });
    </script>
</div>
