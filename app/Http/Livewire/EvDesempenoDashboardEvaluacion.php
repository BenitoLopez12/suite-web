<?php

namespace App\Http\Livewire;

use App\Mail\CorreoRecordatorioEvDesempeno;
use App\Models\Area;
use App\Models\Empleado;
use App\Models\CuestionarioCompetenciaEvDesempeno;
use App\Models\CuestionarioObjetivoEvDesempeno;
use App\Models\EvaluacionDesempeno;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class EvDesempenoDashboardEvaluacion extends Component
{
    public $id_evaluacion;
    public $evaluacion;

    public $areas;
    public $area_select;

    public $evaluadores_evaluado = [];
    public $totales_evaluado = [];

    public $chartData = [10, 20, 30, 40, 50]; // Example data

    protected $listeners = ['loadChartData'];

    public $areas_prueba = ['desarrollo', 'innovacion', 'finanzas'];
    public $datos_prueba = [86, 72, 91];

    public $escalas = [];
    public $listaCompetencias = [];
    public $listaObjetivos = [];

    public function mount($id_evaluacion)
    {
        $this->id_evaluacion = $id_evaluacion;
        $this->areas = Area::getIdNameAll();
    }

    public function render()
    {
        $this->evaluacion = EvaluacionDesempeno::find($this->id_evaluacion);

        $this->evaluadores();
        $this->evaluadoTotales();
        $RPA = $this->resultadoPorArea();
        // $resultadoPorArea = ;

        $this->emit('renderAreas');


        $this->obtenerEscalas();
        $this->obtenerObjetivos();
        $this->obtenerCompetencias();

        return view('livewire.ev-desempeno-dashboard-evaluacion');
    }

    public function obtenerEscalas()
    {
        foreach ($this->evaluacion->escalas as $key => $escala) {
            $this->escalas['nombres'][$key] = $escala->parametro;
            $this->escalas['colores'][$key] = $escala->color;
        }
    }

    public function obtenerObjetivos()
    {
        $query_objetivos = CuestionarioObjetivoEvDesempeno::where('evaluacion_desempeno_id', $this->id_evaluacion)->get();
        // dd($query_objetivos);
        foreach ($query_objetivos as $pregunta) {
            $lista_objetivos[] = $pregunta->infoObjetivo->objetivo;
        }

        $lo = array_unique($lista_objetivos);

        foreach ($lo as $o) {
            $this->listaObjetivos[] = $o;
        }
        // dd($this->listaObjetivos);
    }

    public function obtenerCompetencias()
    {

        $query_competencias = CuestionarioCompetenciaEvDesempeno::where('evaluacion_desempeno_id', $this->id_evaluacion)->get();

        foreach ($query_competencias as $pregunta) {
            $lista_competencias[] = $pregunta->infoCompetencia->competencia;
        }

        $lc = array_unique($lista_competencias);

        foreach ($lc as $c) {
            $this->listaCompetencias[] = $c;
        }
    }

    public function enviarRecordatorio()
    {
        dump($this->evaluacion->evaluados);
        foreach ($this->evaluacion->evaluados as $evaluado) {
            if ($evaluado->estatus_evaluado == false) {
                dd($evaluado);
                if ($this->evaluacion->activar_competencias) {
                    # code...
                    dd($evaluado->evaluadoresCompetencias);
                }

                if ($this->evaluacion->activar_objetivos) {
                    # code...
                    dd($evaluado->evaluadoresObjetivos);
                }
            }
            // dd($evaluado->empleado->email);
        }
    }

    public function cerrarEvaluacion()
    {
        $this->evaluacion->update(
            [
                'estatus' => 2,
            ]
        );
    }

    public function evaluadores()
    {
        $empleados = Empleado::getAllDataColumns();

        foreach ($this->evaluacion->evaluados as $evaluado) {
            foreach ($evaluado->nombres_evaluadores as $key => $id_evaluador) {
                $evaluador = $empleados->find($id_evaluador);

                $this->evaluadores_evaluado[$evaluado->id][] = [
                    'id' => $evaluador->id,
                    'nombre' => $evaluador->name,
                    // 'email' => $evaluador->email, //No necesario
                    'foto' => $evaluador->foto,
                ];
            }
        }
    }

    public function evaluadoTotales()
    {
        foreach ($this->evaluacion->evaluados as $evaluado) {
            $this->totales_evaluado[$evaluado->id] =
                [
                    'competencias' => $evaluado->calificaciones_competencias_evaluado['promedio_total'] * ($this->evaluacion->porcentaje_competencias / 100),
                    'objetivos' => $evaluado->calificaciones_objetivos_evaluado['promedio_total'] * ($this->evaluacion->porcentaje_objetivos / 100),
                    'final' => $evaluado->calificaciones_competencias_evaluado['promedio_total'] * ($this->evaluacion->porcentaje_competencias / 100) + $evaluado->calificaciones_objetivos_evaluado['promedio_total'] * ($this->evaluacion->porcentaje_objetivos / 100),
                ];
        }
    }

    public function resultadoPorArea()
    {
        $areas = Area::getIdNameAll();

        $ids_areas = $this->evaluacion->areas_evaluacion;

        foreach ($ids_areas as $key => $area_id) {
            $area = $areas->find($area_id);
            $nombres_grafica_area[] = $area->area;
        }
        // dd($nombres_grafica_area);
        return $nombres_grafica_area;
    }
}