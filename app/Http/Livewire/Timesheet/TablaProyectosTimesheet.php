<?php

namespace App\Http\Livewire\Timesheet;

use App\Models\Area;
use App\Models\TimesheetProyecto;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class TablaProyectosTimesheet extends Component
{
    use LivewireAlert;

    public $proyectos;
    public $proyecto_name;
    public $area_id;

    public function render()
    {
        $this->proyectos = TimesheetProyecto::get();

        $this->areas = Area::get();

        return view('livewire.timesheet.tabla-proyectos-timesheet');
    }

    public function create()
    {
        $this->validate([
            'proyecto_name'=>'required',
            'area_id'=>'required',
        ]);

        $nuevo_proyecto = TimesheetProyecto::create([
            'proyecto' => $this->proyecto_name,
            'area_id' => $this->area_id,
        ]);

        $this->alert('success', 'Registro añadido!');
    }

    public function destroy($id)
    {
        TimesheetProyecto::destroy($id);

        $this->alert('success', 'Registro eliminado!');
    }
}
