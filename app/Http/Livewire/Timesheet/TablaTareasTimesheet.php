<?php

namespace App\Http\Livewire\Timesheet;

use App\Models\TimesheetProyecto;
use App\Models\TimesheetTarea;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class TablaTareasTimesheet extends Component
{
    use LivewireAlert;

    public $tareas;
    public $proyectos;
    public $proyecto_seleccionado;
    public $tarea_name;
    public $area_select;
    public $proyecto_id;
    public $origen;
    public $tareas_proyecto;

    public $area_seleccionar;

    public $tarea_name_actualizada;

    public function mount($proyecto_id, $origen)
    {
        $this->origen = $origen;
        $this->proyecto_id = $proyecto_id;
        $this->area_seleccionar = null;
    }

    public function render()
    {
        if ($this->origen == 'tareas') {
            $this->proyectos = TimesheetProyecto::get();
            $this->tareas = TimesheetTarea::orderByDesc('id')->get();
        }

        if ($this->origen == 'tareas-proyectos') {
            $this->proyecto_seleccionado = TimesheetProyecto::find($this->proyecto_id);
            $this->tareas = TimesheetTarea::where('proyecto_id', $this->proyecto_id)->orderByDesc('id')->get();
            $this->area_seleccionar = $this->proyecto_seleccionado->areas;
        }

        $this->emit('scriptTabla');

        return view('livewire.timesheet.tabla-tareas-timesheet');
    }

    public function create()
    {
        if ($this->area_select == 0) {
            $area_id = null;
            $todos = true;
        } else {
            $area_id = $this->area_select;
            $todos = false;
        }
        if ($this->origen == 'tareas') {
            $proyecto_procesado = $this->proyecto_id;
        } else {
            $proyecto_procesado = $this->proyecto_seleccionado->id;
        }
        $nueva_tarea = TimesheetTarea::create([
            'tarea' => $this->tarea_name,
            'proyecto_id' => $proyecto_procesado,
            'area_id' => $area_id,
            'todos' => $todos,
        ]);
        $this->emit('tarea-actualizada', $nueva_tarea);

        $this->alert('success', 'Registro añadido!');
    }

    public function actualizarNameTarea($id, $value)
    {
        $tarea_actualizada = TimesheetTarea::find($id);

        $tarea_actualizada->update([
            'tarea'=>$value,
        ]);
        $this->emit('tarea-actualizada', $tarea_actualizada);
    }

    public function actualizarAreaTarea($id, $value)
    {
        $tarea_actualizada = TimesheetTarea::find($id);

        if ($value == 0) {
            $area_id = null;
            $todos = true;
        } else {
            $area_id = $value;
            $todos = false;
        }

        $tarea_actualizada->update([
            'area_id'=>$area_id,
            'todos'=>$todos,
        ]);
        $this->emit('tarea-actualizada', $tarea_actualizada);
    }

    public function llenarAreas($id)
    {
        $this->proyecto_seleccionado = TimesheetProyecto::find($id);
        $this->area_seleccionar = $this->proyecto_seleccionado->areas;
    }

    public function destroy($id)
    {
        TimesheetTarea::destroy($id);

        $this->alert('success', 'Registro eliminado!');
    }
}
