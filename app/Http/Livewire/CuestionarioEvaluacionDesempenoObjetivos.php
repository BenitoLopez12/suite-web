<?php

namespace App\Http\Livewire;

use App\Models\CuestionarioObjetivoEvDesempeno;
use App\Models\EscalasMedicionObjetivos;
use App\Models\EvaluacionDesempeno;
use App\Models\EvidenciaObjCuestionarioEvDesempeno;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class CuestionarioEvaluacionDesempenoObjetivos extends Component
{
    use WithFileUploads;
    use LivewireAlert;

    //Basicos
    public $evaluador;
    public $id_evaluacion;
    public $id_evaluado;

    //Traer datos de la evaluación
    public $evaluacion;
    public $evaluado;
    public $objetivos_evaluado;
    public $objetivos_autoevaluado;
    public $obj_evidencias = [];
    public $calificacion_escala = [];
    public $calificacion_autoescala = [];

    //Campos para validación dependiendo de lo que el evaluador vaya a evaluar
    public $validacion_objetivos_evaluador;

    public $escalas;
    public $conducta;

    public $file = null;
    public $id_obj_arch;
    public $extension_arch;
    public $archivo_mostrado;


    public function mount($id_evaluacion, $id_evaluado)
    {
        $this->evaluador = User::getCurrentUser()->empleado;

        $this->id_evaluacion = $id_evaluacion;
        $this->id_evaluado = $id_evaluado;
    }

    public function render()
    {
        $this->evaluacion = EvaluacionDesempeno::find($this->id_evaluacion);
        $this->evaluado = $this->evaluacion->evaluados->find($this->id_evaluado);
        if ($this->evaluacion->activar_objetivos == true) {

            $this->buscarObjetivos();
        }

        return view('livewire.cuestionario-evaluacion-desempeno-objetivos');
    }

    public function buscarObjetivos()
    {
        $this->escalas = EscalasMedicionObjetivos::get();

        $this->validacion_objetivos_evaluador = false;

        foreach ($this->evaluado->evaluadoresObjetivos as $key => $evlr) {
            if ($evlr->evaluador_desempeno_id == $this->evaluador->id) {
                $this->validacion_objetivos_evaluador = true;

                $this->objetivos_evaluado = $evlr->preguntasCuestionario->sortBy('id');
            }

            if ($evlr->evaluador_desempeno_id == $this->id_evaluado->evaluado_desempeno_id) {
                $this->objetivos_autoevaluado = $evlr->preguntasCuestionario->sortBy('id');
            }
        }
        // dd($this->objetivos_autoevaluado);

        foreach ($this->objetivos_evaluado as $key_objetivo => $obj_evld) {
            foreach ($obj_evld->evidencias as $key_evidencia => $evid) {
                $this->obj_evidencias[$key_objetivo][$key_evidencia] = [
                    "id" => $evid->id,
                    "pregunta_cuest_obj_ev_des_id" => $evid->pregunta_cuest_obj_ev_des_id,
                    "nombre_archivo" => $evid->nombre_archivo,
                    "comentarios" => $evid->comentarios,
                ];
            }

            foreach ($this->objetivos_evaluado as $key_objetivo => $obj_evld) {
                $this->calificacion_escala[$obj_evld->infoObjetivo->id] = 'Sin evaluar';
                foreach ($obj_evld->infoObjetivo->escalas as $obj_esc) {
                    //Se inicializa con el valor inicial para que todos los objetivos tengan su campo correspondiente
                    switch ($obj_esc->condicion) {
                        case '1':
                            if (
                                $obj_evld->calificacion_objetivo <
                                $obj_esc->valor
                            ) {
                                $this->calificacion_escala[$obj_evld->infoObjetivo->id] = $obj_esc->parametro;
                            }
                            break;
                        case '2':
                            if (
                                $obj_evld->calificacion_objetivo <=
                                $obj_esc->valor
                            ) {
                                $this->calificacion_escala[$obj_evld->infoObjetivo->id] = $obj_esc->parametro;
                            }
                            break;
                        case '3':
                            if (
                                $obj_evld->calificacion_objetivo ==
                                $obj_esc->valor
                            ) {
                                $this->calificacion_escala[$obj_evld->infoObjetivo->id] = $obj_esc->parametro;
                            }
                            break;
                        case '4':
                            if (
                                $obj_evld->calificacion_objetivo >
                                $obj_esc->valor
                            ) {
                                $this->calificacion_escala[$obj_evld->infoObjetivo->id] = $obj_esc->parametro;
                            }
                            break;
                        case '5':
                            if (
                                $obj_evld->calificacion_objetivo >=
                                $obj_esc->valor
                            ) {
                                $this->calificacion_escala[$obj_evld->infoObjetivo->id] = $obj_esc->parametro;
                            }
                            break;
                        default:
                            $this->calificacion_escala[$obj_evld->infoObjetivo->id] = $obj_evld->infoObjetivo->escalas[0]->parametro;
                            break;
                    }
                }
            }

            foreach ($this->objetivos_autoevaluado as $key_objetivo => $obj_evld) {
                $this->calificacion_autoescala[$obj_evld->infoObjetivo->id] = 'Sin evaluar';
                foreach ($obj_evld->infoObjetivo->escalas as $obj_esc) {
                    switch ($obj_esc->condicion) {
                        case '1':
                            if (
                                $obj_evld->calificacion_objetivo <
                                $obj_esc->valor
                            ) {
                                $this->calificacion_autoescala[$obj_evld->id] = $obj_esc->parametro;
                            }
                            break;
                        case '2':
                            if (
                                $obj_evld->calificacion_objetivo <=
                                $obj_esc->valor
                            ) {
                                $this->calificacion_autoescala[$obj_evld->id] = $obj_esc->parametro;
                            }
                            break;
                        case '3':
                            if (
                                $obj_evld->calificacion_objetivo ==
                                $obj_esc->valor
                            ) {
                                $this->calificacion_autoescala[$obj_evld->id] = $obj_esc->parametro;
                            }
                            break;
                        case '4':
                            if (
                                $obj_evld->calificacion_objetivo >
                                $obj_esc->valor
                            ) {
                                $this->calificacion_autoescala[$obj_evld->id] = $obj_esc->parametro;
                            }
                            break;
                        case '5':
                            if (
                                $obj_evld->calificacion_objetivo >=
                                $obj_esc->valor
                            ) {
                                $this->calificacion_autoescala[$obj_evld->id] = $obj_esc->parametro;
                            }
                            break;
                        default:
                            $this->calificacion_autoescala[$obj_evld->infoObjetivo->id] = $obj_evld->infoObjetivo->escalas[0]->parametro;
                            break;
                    }
                }
            }
        }
    }

    public function evaluarObjetivo($id_objetivo, $valor)
    {
        try {
            $objetivo = CuestionarioObjetivoEvDesempeno::find($id_objetivo);
            $objetivo->update([
                'calificacion_objetivo' => $valor,
                'estatus_calificado' => true,
            ]);

            $this->alertaGuardadoCorrecto('Respuesta');
            $this->buscarObjetivos();
        } catch (\Throwable $th) {
            $this->alertaGuardadoIncorrecto();
            $this->buscarObjetivos();
        }
    }

    public function updatedFile()
    {
        try {
            $ruta_evidencias = 'public/evaluaciones_desempeno/evaluacion/' . $this->evaluacion->id . '/evidencia/objetivo/' . $this->id_obj_arch . '/evaluado' . '/' . $this->evaluado->id;

            if (!Storage::exists($ruta_evidencias)) {
                Storage::makeDirectory($ruta_evidencias, 0775, true);
            }

            $originalFilename = $this->file->getClientOriginalName();

            $this->file->storeAs($ruta_evidencias, $originalFilename);

            EvidenciaObjCuestionarioEvDesempeno::create([
                'pregunta_cuest_obj_ev_des_id' => $this->id_obj_arch,
                'nombre_archivo' => $originalFilename,
            ]);

            $this->file = null;

            $this->alertaGuardadoCorrecto('Evidencia');
            $this->buscarObjetivos();
        } catch (\Throwable $th) {
            $this->alertaGuardadoIncorrecto();
            $this->buscarObjetivos();
        }
    }

    public function comentarioObjetivo($evidencia_id, $valor)
    {
        try {
            $obj_com = EvidenciaObjCuestionarioEvDesempeno::findOrFail($evidencia_id);

            $obj_com->update([
                'comentarios' => $valor,
            ]);
            $this->alertaGuardadoCorrecto('Comentario');
        } catch (\Throwable $th) {
            $this->alertaGuardadoIncorrecto();
        }
    }

    public function mostrarArchivo($id_archivo_obj, $id_archivo_mostrar)
    {
        $archivo = EvidenciaObjCuestionarioEvDesempeno::findOrFail($id_archivo_mostrar);

        $ruta_evidencias =
            'storage/evaluaciones_desempeno/evaluacion/' . $this->evaluacion->id . '/evidencia/objetivo/' . $id_archivo_obj . '/evaluado' . '/' . $this->evaluado->id . '/' . $archivo->nombre_archivo;

        $extension = pathinfo($ruta_evidencias, PATHINFO_EXTENSION);

        $this->archivo_mostrado = $ruta_evidencias;

        switch ($extension) {
            case 'pdf':
                $this->extension_arch = $extension;
                break;
            case 'jpg':
                $this->extension_arch = $extension;
                break;
            case 'jpeg':
                $this->extension_arch = $extension;
                break;
            case 'png':
                $this->extension_arch = $extension;
                break;
            case 'xls':
                $this->extension_arch = $extension;
                break;
            case 'xlsx':
                $this->extension_arch = $extension;
                break;
            case 'docx':
                $this->extension_arch = $extension;
                break;
            default:
                $this->extension_arch = 'Desconocido';
                break;
        }
    }

    public function asignarObjArchivo($id_obj)
    {
        $this->id_obj_arch = $id_obj;
    }

    public function aplicaObjetivo($obj_apl_id, $valor)
    {
        try {
            $objetivo = CuestionarioObjetivoEvDesempeno::find($obj_apl_id);
            $objetivo->update([
                'aplicabilidad' => $valor,
            ]);

            $this->alertaGuardadoCorrecto('Estatus');
            $this->buscarObjetivos();
        } catch (\Throwable $th) {
            $this->alertaGuardadoIncorrecto();
            $this->buscarObjetivos();
        }
    }

    public function alertaGuardadoCorrecto($alerta)
    {
        $this->alert('success', $alerta . ' Guardada', [
            'position' => 'top-end',
            'timer' => '4000',
            'toast' => true,
            'text' => 'La ' . $alerta . ' se ha guardado correctamente.',
        ]);
    }

    public function alertaGuardadoIncorrecto()
    {
        $this->alert('error', 'Error', [
            'position' => 'top-end',
            'timer' => '4000',
            'toast' => true,
            'text' => 'Ha ocurrido un error al guardar.',
        ]);
    }
}