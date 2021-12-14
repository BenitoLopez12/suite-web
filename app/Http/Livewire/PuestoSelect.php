<?php

namespace App\Http\Livewire;

use App\Models\Puesto;
use Livewire\Component;

class PuestoSelect extends Component
{
    protected $listeners = ['render-puesto-select' => 'render'];
    public $puestos;
    public $puestos_seleccionado;

    public function mount($puestos_seleccionado)
    {
        $this->puestos_seleccionado = $puestos_seleccionado;
        $this->puestos = [];
    }

    public function render()
    {
        $this->puestos = Puesto::get();

        return view('livewire.puesto-select', ['puestos' => $this->puestos]);
    }

    public function hydrate()
    {
        $this->emit('select2');
    }
}
