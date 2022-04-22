<div class="col-12">
    <div class="mt-4 mb-3 w-100" style="border-bottom: solid 2px #345183;">
        <span style="font-size: 17px; font-weight: bold;">
            Debilidades</span>
    </div>

    <div class="mt-2">
        <label for="contacto"><i class="fas fa-thumbs-down iconos-crear"></i>Nombre</label>
        <input class="form-control {{ $errors->has('contacto') ? 'is-invalid' : '' }}" wire:model.defer="debilidad">
        <small class="text-danger errores descripcion_contacto_error"></small>
    </div>

    {{-- <div class="mt-2">
        <label for="contacto"><i class="fas fa-clipboard-list iconos-crear"></i>Riesgo Asociado</label>
        <textarea class="form-control {{ $errors->has('contacto') ? 'is-invalid' : '' }}" wire:model.defer="riesgo">{{ old('riesgo') }}</textarea>
        <small class="text-danger errores descripcion_contacto_error"></small>
    </div> --}}


    <div class="mb-3 col-12 mt-4 " style="text-align: end">
        <button type="button" wire:click.prevent="{{$view =='create' ? 'save':'update'}}"
        class="btn btn-success">Agregar</button>
    </div>


    <div class="mt-3 mb-4 col-12 w-100 datatable-fix p-0">
        <table class="table w-100" id="contactos_table" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Debilidad</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody >
                @foreach ($debilidades as $index=>$debilidad)
                <tr>
                    <td>
                        {{$index+1}}
                    </td>
                    <td>
                        {{$debilidad->debilidad}}
                    </td>
                    <td>
                        <i wire:click="destroy({{ $debilidad->id }})" class="fas fa-trash-alt text-danger"></i>
                        <i class="fas fa-edit text-primary ml-4" wire:click="edit({{ $debilidad->id }})"></i>
                        <i class="text-danger ml-4 fas fa-exclamation-triangle" wire:click="$emit('modalRiesgoFoda',{{$debilidad->id}},'debilidad')" data-toggle="modal"
                            data-target="#marcaslec" title="Asociar un Riesgo"></i>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="modal fade" id="marcaslec" wire:ignore.self tabindex="-1"
        aria-labelledby="marcaslecLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Riesgo Asociados</h5>
                </div>
                <div class="modal-body">
                    <div>
                        @livewire('riesgos-foda')
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>
