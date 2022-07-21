         <!-- Nombre Field -->
         <div class="row">
             <div class="form-group col-sm-6">
                 <i class="fas fa-id-card iconos-crear"></i>{!! Form::label('nombre', 'Nombre:', ['class' => 'required']) !!}
                 {!! Form::text('nombre', null, [
                     'class' => 'form-control',
                     'maxlength' => 255,
                     'maxlength' => 255,
                     'placeholder' => 'Esciba nombre de la incidencia...',
                 ]) !!}
             </div>
             <div class="form-group col-sm-6">
                 <i class="fa-solid fa-circle-play iconos-crear"></i>{!! Form::label('dias_aplicados', 'Días aplicados:', ['class' => 'required']) !!}
                 {!! Form::number('dias_aplicados', null, [
                     'class' => 'form-control',
                     'placeholder' => 'Ingrese el numero de dias ...',
                 ]) !!}
             </div>
         </div>
         <!-- Descripcion Field -->
         <div class="row">
             <div class="form-group col-sm-6">
                 <i class="fa-solid fa-circle-play iconos-crear"></i>{!! Form::label('aniversario', 'Aniversario afectado:', ['class' => 'required']) !!}
                 {!! Form::number('aniversario', null, [
                     'class' => 'form-control',
                     'placeholder' => 'Ingrese el aniversario en que se aplicara la incidecia...',
                 ]) !!}
             </div>

             <div class="form-group col-sm-6">
                 <label for="efecto" class="required"><i
                         class="fa-solid fa-calendar-days iconos-crear"></i>Efecto</label>
                 <select id="efecto" name="efecto" class="form-control">
                     <option value="1"
                         {{ old('efecto') == $vacacion->efecto ? ' selected="selected"' : '' }}>
                         Sumar</option>
                     <option value="2"
                         {{ old('efecto') == $vacacion->efecto ? ' selected="selected"' : '' }}>
                         Restar</option>
                     <option disabled
                         {{ old('efecto') == $vacacion->efecto ? ' selected="selected"' : '' }}>
                         Seleccione...</option>
                 </select>
             </div>
         </div>
         <div class="row">
             <div class="form-group col-sm-12 mt-4">
                 <label for="normas"><i class="fa-solid fa-arrows-down-to-people iconos-crear"></i>Colaborador(es) a
                     aplicar</label>
                 <select
                     class="form-control js-example-basic-multiple empleados-select  {{ $errors->has('controles') ? 'is-invalid' : '' }}"
                     name="empleados[]" id="empleados" multiple="multiple">
                     @foreach ($empleados as $empleado)
                         <option value="{{ $empleado->id }}" data-area="{{ $empleado->name }}"
                             {{ old('areas', in_array($empleado->id, $empleados_seleccionados)) ? ' selected="selected"' : '' }}>
                             {{ $empleado->name }}
                         </option>
                     @endforeach
                 </select>
                 @if ($errors->has('areas'))
                     <div class="invalid-feedback">
                         {{ $errors->first('areas') }}
                     </div>
                 @endif
             </div>
         </div>
         <!-- Descripcion Field -->
         <div class="row">
             <div class="form-group col-sm-12">
                 <label for="exampleFormControlTextarea1"> <i
                         class="fas fa-file-alt iconos-crear"></i>{!! Form::label('descripcion', 'Descripción:') !!}</label>
                 <textarea class="form-control" id="descripcion" name="descripcion" rows="2">{{ old('descripcion', $vacacion->descripcion) }}</textarea>
             </div>
         </div>

         <!-- Submit Field -->
         <div class="text-right form-group col-12">
             <a href="{{ redirect()->getUrlGenerator()->previous() }}" class="btn_cancelar">Cancelar</a>
             <button class="btn btn-danger" type="submit">
                 {{ trans('global.save') }}
             </button>
         </div>

         @section('scripts')
             <script>
                 $(document).ready(function() {

                     $('.empleados-select').select2({
                         'theme': 'bootstrap4'
                     });

                 });
             </script>
         @endsection
