<?php

namespace App\Http\Controllers\Admin;

use App\Functions\Mriesgos;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyMatrizRiesgoRequest;
use App\Http\Requests\StoreMatrizRiesgoRequest;
use App\Http\Requests\UpdateMatrizRiesgoRequest;
use App\Models\Activo;
use App\Models\Amenaza;
use App\Models\Area;
use App\Models\Controle;
use App\Models\DeclaracionAplicabilidad;
use App\Models\Empleado;
use App\Models\Matriz31000ActivosInfo;
use App\Models\MatrizIso31000;
use App\Models\MatrizIso31000ControlesPivot;
use App\Models\MatrizNist;
use App\Models\MatrizOctave;
//use Illuminate\Support\Facades\Request;
use App\Models\MatrizoctaveActivosInfo;
use App\Models\MatrizOctaveControlesPivot;
use App\Models\MatrizRiesgo;
use App\Models\MatrizRiesgosControlesPivot;
use App\Models\Organizacion;
use App\Models\PlanImplementacion;
use App\Models\Proceso;
use App\Models\Sede;
use App\Models\Team;
use App\Models\Tipoactivo;
use App\Models\Vulnerabilidad;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class MatrizRiesgosController extends Controller
{
    /*public function index(Request $request)
    {
        /*abort_if(Gate::denies('matriz_riesgo_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        abort_if(Gate::denies('configuracion_sede_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $query = MatrizRiesgo::with(['controles'])->where('id_analisis', '=', $request['id'])->get();
        //dd(%$query);
        if ($request->ajax()) {
            $query = MatrizRiesgo::get();
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'configuracion_sede_show';
                $editGate      = 'configuracion_sede_edit';
                $deleteGate    = 'configuracion_sede_delete';
                $crudRoutePart = 'sedes';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });
            $table->editColumn('sede', function ($row) {
                return $row->sede ? $row->sede : "";
            });
            $table->editColumn('foto_sedes', function ($row) {
                return $row->foto_sedes ? $row->foto_sedes : '';
            });
            $table->editColumn('direccion', function ($row) {
                return $row->direccion ? $row->direccion : "";
            });
            $table->editColumn('ubicacion', function ($row) {
                //return "'lat' => ".$row->latitude. ",'long' => ".$row->longitud ? "'lat' => ".$row->latitude. ",'long' =>".$row->longitud : "";
                return $row->id ? $row->id : "";
            });
            $table->editColumn('descripcion', function ($row) {
                return $row->descripcion ? $row->descripcion : "";
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        $teams = Team::get();
        $numero_sedes = Sede::count();
        $numero_matriz = MatrizRiesgo::count();


        return view('admin.matriz-seguridad', compact('tipoactivos', 'tipoactivos', 'controles', 'teams'));
    }*/

    public function create()
    {
        abort_if(Gate::denies('matriz_riesgo_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sedes = Sede::get();
        $areas = Area::get();
        $procesos = Proceso::get();
        $responsables = Empleado::get();
        $activos = Activo::get();
        $amenazas = Amenaza::get();

        $vulnerabilidades = Vulnerabilidad::get();
        $controles = DeclaracionAplicabilidad::select('id', 'anexo_indice', 'anexo_politica')->get();

        return view('admin.matrizRiesgos.create', compact('activos', 'amenazas', 'vulnerabilidades', 'sedes', 'areas', 'procesos', 'controles', 'responsables'))->with('id_analisis', \request()->idAnalisis);
    }

    public function store(StoreMatrizRiesgoRequest $request)
    {
        //$request->merge(['plan_de_accion' => $request['plan_accion']['0']]);
        // dd($request->controles_id);
        $matrizRiesgo = MatrizRiesgo::create($request->all());

        foreach ($request->controles_id as $item) {
            $control = new MatrizRiesgosControlesPivot();
            // $control->matriz_id = 2;
            $control->matriz_id = $matrizRiesgo->id;
            $control->controles_id = $item;
            $control->save();
        }

        if (isset($request->plan_accion)) {
            // $planImplementacion = PlanImplementacion::find(intval($request->plan_accion)); // Necesario se carga inicialmente el Diagrama Universal de Gantt
            $matrizRiesgo->planes()->sync($request->plan_accion);
        }

        return redirect()->route('admin.matriz-seguridad', ['id' => $request->id_analisis])->with('success', 'Guardado con éxito');
    }

    public function edit(MatrizRiesgo $matrizRiesgo)
    {
        $organizacions = Organizacion::all();
        $teams = Team::get();
        $activos = Activo::get();
        $tipoactivos = Tipoactivo::get();
        $controles = Controle::get();
        $sedes = Sede::get();
        $areas = Area::get();
        $amenazas = Amenaza::get();
        $procesos = Proceso::get();
        $numero_sedes = Sede::count();
        $numero_matriz = MatrizRiesgo::count();
        $responsables = Empleado::get();
        $vulnerabilidades = Vulnerabilidad::get();
        $planes_seleccionados = [];
        $planes = $matrizRiesgo->load('planes');
        if ($matrizRiesgo->planes) {
            foreach ($matrizRiesgo->planes as $plan) {
                array_push($planes_seleccionados, $plan->id);
            }
        }

        return view('admin.matrizRiesgos.edit', compact('planes_seleccionados', 'matrizRiesgo', 'vulnerabilidades', 'controles', 'amenazas', 'activos', 'sedes', 'areas', 'procesos', 'organizacions', 'teams', 'numero_sedes', 'numero_matriz', 'tipoactivos', 'responsables'));
    }

    public function update(UpdateMatrizRiesgoRequest $request, MatrizRiesgo $matrizRiesgo)
    {
        $calculo = new Mriesgos();
        $res = $calculo->CalculoD($request);
        $request->request->add(['resultadoponderacion' => $res]);
        $matrizRiesgo->update($request->all());

        if (isset($request->plan_accion)) {
            // $planImplementacion = PlanImplementacion::find(intval($request->plan_accion)); // Necesario se carga inicialmente el Diagrama Universal de Gantt
            $matrizRiesgo->planes()->sync($request->plan_accion);
        }

        return redirect()->route('admin.matriz-seguridad', ['id' => $request->id_analisis])->with('success', 'Actualizado con éxito');
    }

    public function show(MatrizRiesgo $matrizRiesgo)
    {
        abort_if(Gate::denies('matriz_riesgo_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        /*if (!is_null($matrizRiesgo->activo_id)) {
            $matrizRiesgo->load('activo_id', 'controles');
        }*/

        return view('admin.matrizRiesgos.show', compact('matrizRiesgo'));
    }

    public function destroy(MatrizRiesgo $matrizRiesgo)
    {
        abort_if(Gate::denies('matriz_riesgo_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $matrizRiesgo->delete();

        return back()->with('deleted', 'Registro eliminado con éxito');
    }

    public function massDestroy(MassDestroyMatrizRiesgoRequest $request)
    {
        MatrizRiesgo::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function SeguridadInfo(Request $request)
    {
        // dd($request->all());
        /*$query = MatrizRiesgo::with(['controles'])->where('id_analisis', '=', $request['id'])->get();
        dd($query);*/
        // abort_if(Gate::denies('configuracion_sede_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        //  $query = MatrizRiesgo::with(['controles', 'matriz_riesgos_controles_pivots' => function ($query) {
        //     return $query->with('declaracion_aplicabilidad');
        // }])->where('id_analisis', '=', $request['id'])->get();
        // dd($query);
        abort_if(Gate::denies('analisis_de_riesgos_matriz_riesgo_config'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if ($request->ajax()) {
            $query = MatrizRiesgo::with(['controles', 'matriz_riesgos_controles_pivots' => function ($query) {
                return $query->with('declaracion_aplicabilidad');
            }])->where('id_analisis', '=', $request['id'])->get();
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'analisis_de_riesgos_matriz_riesgo_config_show';
                $editGate = 'analisis_de_riesgos_matriz_riesgo_config_edit';
                $deleteGate = 'analisis_de_riesgos_matriz_riesgo_config_delete';
                $crudRoutePart = 'matriz-riesgos';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('id_sede', function ($row) {
                return $row->sede ? $row->sede->sede : '';
            });
            $table->editColumn('id_proceso', function ($row) {
                return $row->proceso ? $row->proceso->nombre : '';
            });
            $table->editColumn('id_responsable', function ($row) {
                return $row->empleado ? $row->empleado->name : '';
            });
            $table->editColumn('activo_id', function ($row) {
                return $row->activo ? $row->activo->nombreactivo : '';
            });
            $table->editColumn('id_amenaza', function ($row) {
                return $row->amenaza ? $row->amenaza->nombre : '';
            });
            $table->editColumn('id_vulnerabilidad', function ($row) {
                return $row->vulnerabilidad ? $row->vulnerabilidad->nombre : '';
            });
            $table->editColumn('descripcionriesgo', function ($row) {
                return $row->descripcionriesgo ? $row->descripcionriesgo : '';
            });
            $table->editColumn('confidencialidad', function ($row) {
                if ($row->confidencialidad) {
                    return 'Sí' ? 'Sí' : '';
                } else {
                    return 'No' ? 'No' : '';
                }
            });
            $table->editColumn('integridad', function ($row) {
                if ($row->integridad) {
                    return 'Sí' ? 'Sí' : '';
                } else {
                    return 'No' ? 'No' : '';
                }
            });
            $table->editColumn('disponibilidad', function ($row) {
                if ($row->disponibilidad) {
                    return 'Sí' ? 'Sí' : '';
                } else {
                    return 'No' ? 'No' : '';
                }
            });
            $table->editColumn('resultadoponderacion', function ($row) {
                return $row->resultadoponderacion ? $row->resultadoponderacion : '';
            });
            $table->editColumn('probabilidad', function ($row) {
                //return $row->probabilidad ? $row->probabilidad : "";
                switch ($row->probabilidad) {
                    case 0:
                        return 'NULA' ? 'NULA' : '';
                        break;
                    case 3:
                        return 'BAJA' ? 'BAJA' : '';
                        break;
                    case 6:
                        return 'MEDIA' ? 'MEDIA' : '';
                        break;
                    case 9:
                        return 'ALTA' ? 'ALTA' : '';
                        break;
                    default:
                        break;
                }
            });
            $table->editColumn('impacto', function ($row) {
                //return $row->impacto ? $row->impacto : "";
                switch ($row->impacto) {
                    case 0:
                        return 'BAJO' ? 'BAJO' : '';
                        break;
                    case 3:
                        return 'MEDIO' ? 'MEDIO' : '';
                        break;
                    case 6:
                        return 'ALTO' ? 'ALTO' : '';
                        break;
                    case 9:
                        return 'MUY ALTO' ? 'MUY ALTO' : '';
                        break;
                    default:
                        break;
                }
            });
            $table->editColumn('nivelriesgo', function ($row) {
                if (is_null($row->nivelriesgo)) {
                    return null ? $row->nivelriesgo : '';
                } elseif ($row->nivelriesgo == 0) {
                    return 'cero';
                } else {
                    return $row->nivelriesgo ? $row->nivelriesgo : '';
                }
            });
            /*$table->editColumn('riesgototal', function ($row) {
                return $row->riesgototal ? $row->riesgototal : "";
            });*/
            $table->editColumn('control', function ($row) {
                return $row->matriz_riesgos_controles_pivots ? $row->matriz_riesgos_controles_pivots : '';
            });
            $table->editColumn('plan_de_accion', function ($row) {
                return $row->planes ? $row->planes : '';
            });
            $table->editColumn('confidencialidad_cid', function ($row) {
                if ($row->confidencialidad_cid) {
                    return 'Sí' ? 'Sí' : '';
                } else {
                    return 'No' ? 'No' : '';
                }
            });
            $table->editColumn('integridad_cid', function ($row) {
                if ($row->integridad_cid) {
                    return 'Sí' ? 'Sí' : '';
                } else {
                    return 'No' ? 'No' : '';
                }
            });
            $table->editColumn('disponibilidad_cid', function ($row) {
                if ($row->disponibilidad_cid) {
                    return 'Sí' ? 'Sí' : '';
                } else {
                    return 'No' ? 'No' : '';
                }
            });
            $table->editColumn('probabilidad_residual', function ($row) {
                //return $row->probabilidad_residual ? $row->probabilidad_residual : "";
                switch ($row->probabilidad_residual) {
                    case 0:
                        return 'NULA' ? 'NULA' : '';
                        break;
                    case 3:
                        return 'BAJA' ? 'BAJA' : '';
                        break;
                    case 6:
                        return 'MEDIA' ? 'MEDIA' : '';
                        break;
                    case 9:
                        return 'ALTA' ? 'ALTA' : '';
                        break;
                    default:
                        break;
                }
            });
            $table->editColumn('impacto_residual', function ($row) {
                //return $row->impacto_residual ? $row->impacto_residual : "";
                switch ($row->impacto_residual) {
                    case 0:
                        return 'BAJO' ? 'BAJO' : '';
                        break;
                    case 3:
                        return 'MEDIO' ? 'MEDIO' : '';
                        break;
                    case 6:
                        return 'ALTO' ? 'ALTO' : '';
                        break;
                    case 9:
                        return 'MUY ALTO' ? 'MUY ALTO' : '';
                        break;
                    default:
                        break;
                }
            });
            $table->editColumn('nivelriesgo_residual', function ($row) {
                return $row->nivelriesgo_residual ? $row->nivelriesgo_residual : '';
            });
            $table->editColumn('riesto_total_residual', function ($row) {
                return $row->riesto_total_residual ? $row->riesto_total_residual : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        $organizacions = Organizacion::all();
        $teams = Team::get();
        $tipoactivos = Tipoactivo::get();
        $controles = Controle::get();
        $matriz_heat = MatrizRiesgo::with(['controles'])->where('id_analisis', '=', $request['id'])->get();
        $sedes = Sede::get();
        $areas = Area::get();
        $procesos = Proceso::get();
        $numero_sedes = Sede::count();
        $numero_matriz = MatrizRiesgo::count();

        return view('admin.matrizRiesgos.index', compact('sedes', 'areas', 'procesos', 'organizacions', 'teams', 'numero_sedes', 'numero_matriz'))->with('id_matriz', $request['id']);
    }

    public function MapaCalor(Request $request)
    {
        return view('admin.matrizRiesgos.heatchart')->with('id', $request->idAnalisis);
    }

    public function MapaCalorOctave(Request $request)
    {
        return view('admin.OCTAVE.heatchart')->with('id', $request->idAnalisis);
    }

    public function createPlanAccion(MatrizRiesgo $id)
    {
        $planImplementacion = new PlanImplementacion();
        $modulo = $id;
        $modulo_name = 'Matríz de Riegos';
        $referencia = $modulo->nombrerequisito;
        $urlStore = route('admin.matriz-requisito-legales.storePlanAccion', $id);

        return view('admin.planesDeAccion.create', compact('planImplementacion', 'modulo_name', 'modulo', 'referencia', 'urlStore'));
    }

    public function storePlanAccion(Request $request, MatrizRiesgo $id)
    {
        $request->validate([
            'parent' => 'required|string',
            'norma' => 'required|string',
            'modulo_origen' => 'required|string',
            'objetivo' => 'required|string',
        ], [
            'parent.required' => 'Debes de definir un nombre para el plan de acción',
            'norma.required' => 'Debes de definir una norma para el plan de acción',
            'modulo_origen.required' => 'Debes de definir un módulo de origen para el plan de acción',
            'objetivo.required' => 'Debes de definir un objetivo para el plan de acción',
        ]);

        $planImplementacion = new PlanImplementacion(); // Necesario se carga inicialmente el Diagrama Universal de Gantt
        $planImplementacion->tasks = [];
        $planImplementacion->canAdd = true;
        $planImplementacion->canWrite = true;
        $planImplementacion->canWriteOnParent = true;
        $planImplementacion->changesReasonWhy = false;
        $planImplementacion->selectedRow = 0;
        $planImplementacion->zoom = '3d';
        $planImplementacion->parent = $request->parent;
        $planImplementacion->norma = $request->norma;
        $planImplementacion->modulo_origen = $request->modulo_origen;
        $planImplementacion->objetivo = $request->objetivo;
        $planImplementacion->elaboro_id = auth()->user()->empleado->id;

        $matrizRequisitoLegal = $id;
        $matrizRequisitoLegal->planes()->save($planImplementacion);

        return redirect()->route('admin.matriz-requisito-legales.index')->with('success', 'Plan de Acción' . $planImplementacion->parent . ' creado');
    }

    public function ControlesGet()
    {
    }

    public function octaveIndex(Request $request)
    {
        // dd($request->all());
        /*$query = MatrizRiesgo::with(['controles'])->where('id_analisis', '=', $request['id'])->get();
        dd($query);*/
        // abort_if(Gate::denies('configuracion_sede_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        //  $query = MatrizRiesgo::with(['controles', 'matriz_riesgos_controles_pivots' => function ($query) {
        //     return $query->with('declaracion_aplicabilidad');
        // }])->where('id_analisis', '=', $request['id'])->get();
        // dd($query);
        abort_if(Gate::denies('analisis_de_riesgos_matriz_riesgo_config'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if ($request->ajax()) {
            $query = MatrizOctave::get();
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'analisis_de_riesgos_matriz_riesgo_config_show';
                $editGate = 'analisis_de_riesgos_matriz_riesgo_config_edit';
                $deleteGate = 'analisis_de_riesgos_matriz_riesgo_config_delete';
                $crudRoutePart = 'matriz-riesgos';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('vp', function ($row) {
                return $row->vp ? $row->vp : '';
            });
            $table->editColumn('id_area', function ($row) {
                return $row->area ? $row->area->area : '';
            });
            $table->editColumn('servicio', function ($row) {
                return $row->servicio ? $row->servicio : '';
            });
            $table->editColumn('id_sede', function ($row) {
                return $row->sede ? $row->sede->sede : '';
            });
            $table->editColumn('id_proceso', function ($row) {
                return $row->proceso ? $row->proceso->nombre : '';
            });
            $table->editColumn('activo_id', function ($row) {
                return $row->activo ? $row->activo->nombreactivo : '';
            });
            $table->editColumn('operacional', function ($row) {
                return $row->operacional ? $row->operacional : '';
            });
            $table->editColumn('cumplimiento', function ($row) {
                return $row->cumplimiento ? $row->cumplimiento : '';
            });
            $table->editColumn('legal', function ($row) {
                return $row->legal ? $row->legal : '';
            });
            $table->editColumn('reputacional', function ($row) {
                return $row->reputacional ? $row->reputacional : '';
            });
            $table->editColumn('tecnologico', function ($row) {
                return $row->tecnologico ? $row->tecnologico : '';
            });
            $table->editColumn('valor', function ($row) {
                return $row->valor ? $row->valor : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        $organizacions = Organizacion::all();
        $teams = Team::get();
        $tipoactivos = Tipoactivo::get();
        $controles = Controle::get();
        $matriz_heat = MatrizRiesgo::with(['controles'])->where('id_analisis', '=', $request['id'])->get();
        $sedes = Sede::get();
        $areas = Area::get();
        $procesos = Proceso::get();
        $numero_sedes = Sede::count();
        // $numero_matriz = MatrizRiesgo::count();
        $numero_matriz = MatrizOctave::count();

        return view('admin.OCTAVE.index', compact('sedes', 'areas', 'procesos', 'organizacions', 'teams', 'numero_sedes', 'numero_matriz'))->with('id_matriz', $request->id);
    }

    public function octave(Request $request)
    {
        $sedes = Sede::get();
        $areas = Area::get();
        $procesos = Proceso::get();
        // $responsables = Empleado::get();
        $activos = Activo::get();
        $amenazas = Amenaza::get();
        $duenos = Empleado::get();
        $custodios = Empleado::get();
        $vulnerabilidades = Vulnerabilidad::get();
        $controles = DeclaracionAplicabilidad::select('id', 'anexo_indice', 'anexo_politica')->get();
        $activosoctave = MatrizOctave::get();
        $matrizOctave = new MatrizOctave();

        return view('admin.OCTAVE.create', compact('activos', 'amenazas', 'vulnerabilidades', 'sedes', 'areas', 'procesos', 'controles', 'duenos', 'custodios', 'activosoctave', 'matrizOctave'))->with('id_analisis', $request->id_analisis);
    }

    public function octaveEdit(Request $request, $id)
    {
        $sedes = Sede::get();
        $areas = Area::get();
        $procesos = Proceso::get();
        $activos = Activo::get();
        $amenazas = Amenaza::get();
        $duenos = Empleado::get();
        $custodios = Empleado::get();
        $vulnerabilidades = Vulnerabilidad::get();
        $controles = DeclaracionAplicabilidad::select('id', 'anexo_indice', 'anexo_politica')->get();
        $activosoctave = MatrizOctave::get();
        $matrizOctave = MatrizOctave::with('matrizActivos')->find($id);

        return view('admin.OCTAVE.edit', compact('activos', 'amenazas', 'vulnerabilidades', 'sedes', 'areas', 'procesos', 'controles', 'duenos', 'custodios', 'activosoctave', 'matrizOctave'))->with('id_analisis', $request->id_analisis);
    }

    public function updateOctave(Request $request, $matrizRiesgoOctave)
    {
        // $calculo = new Mriesgos();
        // $res = $calculo->CalculoD($request);
        // $request->request->add(['resultadoponderacion' => $res]);
        $matrizRiesgoOctave = MatrizOctave::find($matrizRiesgoOctave);
        $matrizRiesgoOctave->update($request->all());
        $this->saveUpdateActivosOctave($request->activosoctave, $matrizRiesgoOctave);

        return redirect("admin/matriz-seguridad/octave/index?id={$request->id_analisis}")->with('success', 'Editado con éxito');
        // if (isset($request->plan_accion)) {
        //     $planImplementacion = PlanImplementacion::find(intval($request->plan_accion)); // Necesario se carga inicialmente el Diagrama Universal de Gantt
        //     $matrizRiesgoOctave->planes()->sync($request->plan_accion);
        // }

        return redirect()->route('admin.matriz-riesgos.octave', ['id' => $request->id_analisis])->with('success', 'Actualizado con éxito');
    }

    public function deleteActivoOctave(Request $request)
    {
        $matrizRiesgoOctave = MatrizoctaveActivosInfo::find($request->id);
        $matrizRiesgoOctave->delete();

        return response()->json(['status' => 200]);
    }

    public function storeOctave(Request $request)
    {
        //$request->merge(['plan_de_accion' => $request['plan_accion']['0']]);
        // dd($request->all());
        $matrizRiesgoOctave = MatrizOctave::create($request->all());

        // foreach ($request->controles_id as $item) {
        //     $control = new MatrizOctaveControlesPivot();
        //     // $control->matriz_id = 2;
        //     $control->matriz_id = $matrizRiesgoOctave->id;
        //     $control->controles_id = $item;
        //     $control->save();
        // }

        // if (isset($request->plan_accion)) {
        //     // $planImplementacion = PlanImplementacion::find(intval($request->plan_accion)); // Necesario se carga inicialmente el Diagrama Universal de Gantt
        //     $matrizRiesgoOctave->planes()->sync($request->plan_accion);
        // }

        $this->saveUpdateActivosOctave($request->activosoctave, $matrizRiesgoOctave);

        return redirect("admin/matriz-seguridad/octave/index?id={$request->id_analisis}")->with('success', 'Guardado con éxito');
    }

    public function ISO31000(Request $request)
    {
        // dd($request->all());
        /*$query = MatrizRiesgo::with(['controles'])->where('id_analisis', '=', $request['id'])->get();
        dd($query);*/
        // abort_if(Gate::denies('configuracion_sede_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        //  $query = MatrizRiesgo::with(['controles', 'matriz_riesgos_controles_pivots' => function ($query) {
        //     return $query->with('declaracion_aplicabilidad');
        // }])->where('id_analisis', '=', $request['id'])->get();
        // dd($query);
        abort_if(Gate::denies('analisis_de_riesgos_matriz_riesgo_config'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if ($request->ajax()) {
            $query = MatrizIso31000::get();
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'analisis_de_riesgos_matriz_riesgo_config_show';
                $editGate = 'analisis_de_riesgos_matriz_riesgo_config_edit';
                $deleteGate = 'analisis_de_riesgos_matriz_riesgo_config_delete';
                $crudRoutePart = 'matriz-riesgos';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('proveedores', function ($row) {
                return $row->proveedores ? $row->proveedores : '';
            });
            $table->editColumn('servicio', function ($row) {
                return $row->servicio ? $row->servicio : '';
            });
            $table->editColumn('id_proceso', function ($row) {
                return $row->proceso ? $row->proceso->nombre : '';
            });
            $table->editColumn('descripcion_servicio', function ($row) {
                return $row->descripcion_servicio ? $row->descripcion_servicio : '';
            });
            $table->editColumn('estrategico', function ($row) {
                return $row->estrategico ? $row->estrategico : '';
            });
            $table->editColumn('operacional', function ($row) {
                return $row->operacional ? $row->operacional : '';
            });
            $table->editColumn('cumplimiento', function ($row) {
                return $row->cumplimiento ? $row->cumplimiento : '';
            });
            $table->editColumn('legal', function ($row) {
                return $row->legal ? $row->legal : '';
            });
            $table->editColumn('reputacional', function ($row) {
                return $row->reputacional ? $row->reputacional : '';
            });
            $table->editColumn('tecnologico', function ($row) {
                return $row->tecnologico ? $row->tecnologico : '';
            });
            $table->editColumn('valor', function ($row) {
                return $row->valor ? $row->valor : '';
            });
            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        $organizacions = Organizacion::all();
        $teams = Team::get();
        $tipoactivos = Tipoactivo::get();
        $controles = Controle::get();
        $matriz_heat = MatrizRiesgo::with(['controles'])->where('id_analisis', '=', $request['id'])->get();
        $sedes = Sede::get();
        $areas = Area::get();
        $procesos = Proceso::get();
        $numero_sedes = Sede::count();
        // $numero_matriz = MatrizRiesgo::count();
        $numero_matriz = MatrizIso31000::count();

        return view('admin.MatrizISO31000.index', compact('sedes', 'areas', 'procesos', 'organizacions', 'teams', 'numero_sedes', 'numero_matriz'))->with('id_matriz', $request['id']);
    }

    public function ISO31000Create(Request $request)
    {
        $sedes = Sede::get();
        $areas = Area::get();
        $procesos = Proceso::get();
        $responsables = Empleado::get();
        $activos = Activo::get();
        $amenazas = Amenaza::get();

        $vulnerabilidades = Vulnerabilidad::get();
        $controles = DeclaracionAplicabilidad::select('id', 'anexo_indice', 'anexo_politica')->get();
        $activosmatriz31000 = MatrizIso31000::get();

        return view('admin.MatrizISO31000.create', compact('activosmatriz31000', 'activos', 'amenazas', 'vulnerabilidades', 'sedes', 'areas', 'procesos', 'controles', 'responsables'))->with('id_analisis', $request->id_analisis);
    }

    public function ISO31000Edit(Request $request, $id)
    {
        $sedes = Sede::get();
        $areas = Area::get();
        $procesos = Proceso::get();
        $responsables = Empleado::get();
        $activos = Activo::get();
        $amenazas = Amenaza::get();

        $vulnerabilidades = Vulnerabilidad::get();
        $controles = DeclaracionAplicabilidad::select('id', 'anexo_indice', 'anexo_politica')->get();
        $activosmatriz31000 = MatrizIso31000::find($id);

        return view('admin.MatrizISO31000.create', compact('activosmatriz31000', 'activos', 'amenazas', 'vulnerabilidades', 'sedes', 'areas', 'procesos', 'controles', 'responsables'))->with('id_analisis', $request->id_analisis);
    }

    public function ISO31000Store(Request $request)
    {
        $matrizIso3100 = MatrizIso31000::create($request->all());
        $this->saveUpdateMatriz31000ActivosInfo($request->activosmatriz31000, $matrizIso3100);

        return redirect("admin/matriz-seguridad/ISO31000?id={$request->id_analisis}")->with('success', 'Guardado con éxito');
    }

    public function updateMatriz31000(Request $request, MatrizIso31000 $matrizRiesgo31000)
    {
        $calculo = new Mriesgos();
        $res = $calculo->CalculoD($request);
        $request->request->add(['resultadoponderacion' => $res]);
        $matrizRiesgo31000->update($request->all());

        if (isset($request->plan_accion)) {
            // $planImplementacion = PlanImplementacion::find(intval($request->plan_accion)); // Necesario se carga inicialmente el Diagrama Universal de Gantt
            $matrizRiesgo31000->planes()->sync($request->plan_accion);
        }

        return redirect()->route('admin.matriz-riesgos.octave', ['id' => $request->id_analisis])->with('success', 'Actualizado con éxito');
    }

    public function NIST(Request $request)
    {
        abort_if(Gate::denies('analisis_de_riesgos_matriz_riesgo_config'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if ($request->ajax()) {
            $query = MatrizNist::get();
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'analisis_de_riesgos_matriz_riesgo_config_show';
                $editGate = 'analisis_de_riesgos_matriz_riesgo_config_edit';
                $deleteGate = 'analisis_de_riesgos_matriz_riesgo_config_delete';
                $crudRoutePart = 'matriz-riesgos';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('nombre', function ($row) {
                return $row->nombre ? $row->nombre : '';
            });
            $table->editColumn('amenaza', function ($row) {
                return $row->amenaza ? $row->amenaza : '';
            });
            $table->editColumn('impacto_vulnerabilidad', function ($row) {
                return $row->impacto_vulnerabilidad ? $row->impacto_vulnerabilidad : '';
            });
            $table->editColumn('aplicaciones', function ($row) {
                return $row->aplicaciones ? $row->aplicaciones : '';
            });
            $table->editColumn('escenario', function ($row) {
                return $row->escenario ? $row->escenario : '';
            });
            $table->editColumn('categoria', function ($row) {
                return $row->categoria ? $row->categoria : '';
            });
            $table->editColumn('causa', function ($row) {
                return $row->causa ? $row->causa : '';
            });
            $table->editColumn('tipo', function ($row) {
                return $row->tipo ? $row->tipo : '';
            });
            $table->editColumn('severidad', function ($row) {
                return $row->severidad ? $row->severidad : '';
            });
            $table->editColumn('probabilidad', function ($row) {
                return $row->probabilidad ? $row->probabilidad : '';
            });
            $table->editColumn('impacto_num', function ($row) {
                return $row->impacto_num ? $row->impacto_num : '';
            });
            $table->editColumn('valor', function ($row) {
                return $row->valor ? $row->valor : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        $organizacions = Organizacion::all();
        $teams = Team::get();
        $tipoactivos = Tipoactivo::get();
        $controles = Controle::get();
        $matriz_heat = MatrizRiesgo::with(['controles'])->where('id_analisis', '=', $request['id'])->get();
        $sedes = Sede::get();
        $areas = Area::get();
        $procesos = Proceso::get();
        $numero_sedes = Sede::count();
        $numero_matriz = MatrizRiesgo::count();

        return view('admin.NIST.index', compact('sedes', 'areas', 'procesos', 'organizacions', 'teams', 'numero_sedes', 'numero_matriz'))->with('id_matriz', $request['id']);
    }

    public function NISTCreate(Request $request)
    {
        $sedes = Sede::get();
        $areas = Area::get();
        $procesos = Proceso::get();
        $responsables = Empleado::get();
        $activos = Activo::get();
        $amenazas = Amenaza::get();
        $matrizNist = new MatrizNist();
        $vulnerabilidades = Vulnerabilidad::get();
        $controles = DeclaracionAplicabilidad::select('id', 'anexo_indice', 'anexo_politica')->get();

        return view('admin.NIST.create', compact('activos', 'amenazas', 'vulnerabilidades', 'sedes', 'areas', 'procesos', 'controles', 'responsables', 'matrizNist'))->with('id_analisis', $request->id_analisis);
    }

    public function NISTEdit(Request $request, $id)
    {
        $sedes = Sede::get();
        $areas = Area::get();
        $procesos = Proceso::get();
        $responsables = Empleado::get();
        $activos = Activo::get();
        $amenazas = Amenaza::get();
        $matrizNist = MatrizNist::find($id);
        $vulnerabilidades = Vulnerabilidad::get();
        $controles = DeclaracionAplicabilidad::select('id', 'anexo_indice', 'anexo_politica')->get();

        return view('admin.NIST.edit', compact('activos', 'amenazas', 'vulnerabilidades', 'sedes', 'areas', 'procesos', 'controles', 'responsables', 'matrizNist'))->with('id_analisis', $request->id_analisis);
    }

    public function NISTStore(Request $request)
    {
        MatrizNist::create($request->all());

        return redirect("admin/matriz-seguridad/NIST?id={$request->id_analisis}")->with('success', 'Guardado con éxito');
    }

    public function NISTUpdate(Request $request, $id)
    {
        $matrizNist = MatrizNist::find($id);
        $matrizNist->update($request->all());

        return redirect("admin/matriz-seguridad/NIST?id={$request->id_analisis}")->with('success', 'Editado con éxito');
    }

    public function storeMatriz31000(Request $request)
    {
        //$request->merge(['plan_de_accion' => $request['plan_accion']['0']]);
        // dd($request->controles_id);
        $matrizRiesgo31000 = MatrizIso31000::create($request->all());

        foreach ($request->controles_id as $item) {
            $control = new MatrizIso31000ControlesPivot();
            // $control->matriz_id = 2;
            $control->matriz_id = $matrizRiesgo31000->id;
            $control->controles_id = $item;
            $control->save();
        }

        if (isset($request->plan_accion)) {
            // $planImplementacion = PlanImplementacion::find(intval($request->plan_accion)); // Necesario se carga inicialmente el Diagrama Universal de Gantt
            $matrizRiesgo31000->planes()->sync($request->plan_accion);
        }

        $this->saveUpdateMatriz31000ActivosInfo($request->externos, $matrizRiesgo31000);

        return redirect()->route('admin.matriz-riesgos.octave', ['id' => $request->id_analisis])->with('success', 'Guardado con éxito');
    }

    public function saveUpdateActivosOctave($activosoctave, $matrizRiesgoOctave)
    {
        if (!is_null($activosoctave)) {
            foreach ($activosoctave as $activoctave) {
                // dd(PuestoResponsabilidade::exists($responsabilidad['id']));
                if (!is_null(MatrizoctaveActivosInfo::find($activoctave['id']))) {
                    MatrizoctaveActivosInfo::find($activoctave['id'])->update([
                        'nombre_ai' => $activoctave['nombre_ai'],
                        'valor_criticidad' =>  $activoctave['valor_criticidad'],
                        'contenedor_activos' =>  $activoctave['contenedor_activos'],
                        'id_amenaza' =>  $activoctave['id_amenaza'],
                        'id_vulnerabilidad' =>  $activoctave['id_vulnerabilidad'],
                        'escenario_riesgo' =>  $activoctave['escenario_riesgo'],
                        'id_custodio' =>  $activoctave['id_custodio'],
                        'id_dueno' =>  $activoctave['id_dueno'],
                        'confidencialidad' =>  $activoctave['confidencialidad'],
                        'disponibilidad' =>  $activoctave['disponibilidad'],
                        'integridad' =>  $activoctave['integridad'],
                        'evaluacion_riesgo' =>  $activoctave['evaluacion_riesgo'],

                    ]);
                } else {
                    MatrizoctaveActivosInfo::create([
                        'id_octave' => $matrizRiesgoOctave->id,
                        'nombre_ai' => $activoctave['nombre_ai'],
                        'valor_criticidad' =>  $activoctave['valor_criticidad'],
                        'contenedor_activos' =>  $activoctave['contenedor_activos'],
                        'id_amenaza' =>  $activoctave['id_amenaza'],
                        'id_vulnerabilidad' =>  $activoctave['id_vulnerabilidad'],
                        'escenario_riesgo' =>  $activoctave['escenario_riesgo'],
                        'id_custodio' =>  $activoctave['id_custodio'],
                        'id_dueno' =>  $activoctave['id_dueno'],
                        'confidencialidad' =>  $activoctave['confidencialidad'],
                        'disponibilidad' =>  $activoctave['disponibilidad'],
                        'integridad' =>  $activoctave['integridad'],
                        'evaluacion_riesgo' =>  $activoctave['evaluacion_riesgo'],
                    ]);
                }
            }
        }
        // dd($activosoctave);
    }

    public function saveUpdateMatriz31000ActivosInfo($activosmatriz31000, $matrizRiesgo31000)
    {
        if (!is_null($activosmatriz31000)) {
            foreach ($activosmatriz31000 as $activomatriz31000) {
                // dd(PuestoResponsabilidade::exists($responsabilidad['id']));
                if (Matriz31000ActivosInfo::find($activomatriz31000['id']) != null) {
                    Matriz31000ActivosInfo::find($activomatriz31000['id'])->update([
                        'contenedor_activos' =>  $activomatriz31000['contenedor_activos'],
                        'id_amenaza' =>  $activomatriz31000['id_amenaza'],
                        'id_vulnerabilidad' => $activomatriz31000['id_vulnerabilidad'],
                        'escenario_riesgo' =>  $activomatriz31000['escenario_riesgo'],
                        'confidencialidad' =>  $activomatriz31000['confidencialidad'],
                        'disponibilidad' =>  $activomatriz31000['disponibilidad'],
                        'integridad' =>  $activomatriz31000['integridad'],
                        'evaluacion_riesgo' =>  $activomatriz31000['evaluacion_riesgo'],
                        // 'activo_id' =>  $activomatriz31000['activo_id']
                    ]);
                } else {
                    Matriz31000ActivosInfo::create([
                        'id_matriz31000' => $matrizRiesgo31000->id,
                        'contenedor_activos' =>  $activomatriz31000['contenedor_activos'],
                        'id_amenaza' =>  $activomatriz31000['id_amenaza'],
                        'id_vulnerabilidad' => $activomatriz31000['id_vulnerabilidad'],
                        'escenario_riesgo' =>  $activomatriz31000['escenario_riesgo'],
                        'confidencialidad' =>  $activomatriz31000['confidencialidad'],
                        'disponibilidad' =>  $activomatriz31000['disponibilidad'],
                        'integridad' =>  $activomatriz31000['integridad'],
                        'evaluación_riesgo' =>  $activomatriz31000['evaluacion_riesgo'],
                        // 'activo_id' =>  $activomatriz31000['activo_id']
                    ]);
                }
            }
        }
    }
}
