<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

use App\Mail\RespuestaVacaciones as MailRespuestaVacaciones;
use App\Mail\SolicitudVacaciones as MailSolicitudVacaciones;

use App\Models\Empleado;
use App\Models\IncidentesVacaciones;
use App\Models\Organizacion;
use App\Models\SolicitudDayOff;
use App\Models\SolicitudPermisoGoceSueldo;
use App\Models\SolicitudVacaciones;
use Flash;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Vacaciones;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Exists;

class SolicitudVacacionesController extends Controller
{

    public function index(Request $request)
    {

        abort_if(Gate::denies('solicitud_vacaciones_acceder'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $data = auth()->user()->empleado->id;

        if ($request->ajax()) {
            $query = SolicitudVacaciones::with('empleado')->where('empleado_id', '=', $data)->orderByDesc('id')->get();
            $table = datatables()::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'amenazas_ver';
                $editGate = 'no_permitido';
                $deleteGate = 'amenazas_eliminar';
                $crudRoutePart = 'solicitud-vacaciones';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('dias_solicitados', function ($row) {
                return $row->dias_solicitados ? $row->dias_solicitados : '';
            });
            $table->editColumn('fecha_inicio', function ($row) {
                return $row->fecha_inicio ? $row->fecha_inicio : '';
            });
            $table->editColumn('fecha_fin', function ($row) {
                return $row->fecha_fin ? $row->fecha_fin : '';
            });
            // $table->editColumn('descripcion', function ($row) {
            //     return $row->descripcion ? $row->descripcion : '';
            // });
            $table->editColumn('aprobacion', function ($row) {
                return $row->aprobacion ? $row->aprobacion : '';
            });
            $table->editColumn('año', function ($row) {
                return $row->año ? $row->año : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }
        $organizacion_actual = Organizacion::select('empresa', 'logotipo')->first();
        if (is_null($organizacion_actual)) {
            $organizacion_actual = new Organizacion();
            $organizacion_actual->logotipo = asset('img/logo.png');
            $organizacion_actual->empresa = 'Silent4Business';
        }
        $logo_actual = $organizacion_actual->logotipo;
        $empresa_actual = $organizacion_actual->empresa;


        $ingreso = auth()->user()->empleado->antiguedad;
        $dia_hoy = Carbon::now();
        $seis_meses = ($dia_hoy->diffInMonths($ingreso));
        if ($seis_meses >= 6) {
            $dias_disponibles_date = $this->diasDisponibles();
            if ($dias_disponibles_date > 0) {
                $dias_disponibles = $this->diasDisponibles();
            } else {
                $dias_disponibles = 0;
            }
        }else{
            $dias_disponibles = 0;
        }


        return view('admin.solicitudVacaciones.index', compact('logo_actual', 'empresa_actual', 'dias_disponibles'));
    }


    public function create()
    {   
        abort_if(Gate::denies('solicitud_vacaciones_crear'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $ingreso = auth()->user()->empleado->antiguedad;
        $dia_hoy = Carbon::now();
        $no_vacaciones = $ingreso->format('d-m-Y');
        $año = Carbon::createFromDate($ingreso)->age;
        $seis_meses = ($dia_hoy->diffInMonths($ingreso));
       
        if ($año == 0) {
           
            $año = 1;
        }else{
           
        }
       

        //  Determina si existe regla asociada
        $existe_regla_por_area = Vacaciones::where('inicio_conteo', '=', $año)->whereHas('areas', function ($q) {
            $q->where('area_id', auth()->user()->empleado->area_id);
        })->select('dias', 'tipo_conteo')->exists();
        $existe_regla_toda_empresa = Vacaciones::where('inicio_conteo', $año)->where('afectados', 1)->select('dias', 'tipo_conteo')->exists();

        if ($seis_meses >= 6) {
            if ($existe_regla_toda_empresa) {
                $regla_aplicada = Vacaciones::where('inicio_conteo', $año)->where('afectados', 1)->select('dias', 'tipo_conteo')->first();
            } elseif ($existe_regla_por_area) {
                $regla_aplicada = Vacaciones::where('inicio_conteo', '=', $año)->whereHas('areas', function ($q) {
                    $q->where('area_id', auth()->user()->empleado->area_id);
                })->select('dias', 'tipo_conteo')->first();
            } else {
                Flash::error('Regla de vacaciones no asociada');
                return redirect(route('admin.solicitud-vacaciones.index'));
            }
            // Inician vacaciones a los 6 meses
        }
       
        else {
            $tipo_conteo = null;
            $fecha_limite = Vacaciones::where('inicio_conteo', '=', $año)->pluck('fin_conteo')->first();
            $inicio_vacaciones = $ingreso->addYear();
            $finVacaciones = $inicio_vacaciones->addYear($año);
            $finVacaciones = $finVacaciones->format('d-m-Y');
            $autoriza = auth()->user()->empleado->supervisor_id;
            $vacacion = new SolicitudVacaciones();
            $dias_disponibles = null;
            $organizacion = Organizacion::first();
            $dias_pendientes = null;
            $mostrar_reclamo = false;
            $año_pasado = 0;
            $periodo_vencido = 0;
            $finVacaciones_periodo_pasado = null;

            return view('admin.solicitudVacaciones.create', compact('finVacaciones_periodo_pasado','periodo_vencido','año_pasado','mostrar_reclamo','vacacion', 'dias_disponibles', 'año', 'autoriza', 'no_vacaciones', 'organizacion', 'finVacaciones', 'dias_pendientes', 'tipo_conteo'));
        }

        $tipo_conteo = $regla_aplicada->tipo_conteo;
        $fecha_limite = Vacaciones::where('inicio_conteo', '=', $año)->pluck('fin_conteo')->first();
        $inicio_vacaciones = $ingreso->addYear();
        $finVacaciones = $inicio_vacaciones->addYear($año);
        $finVacaciones = $finVacaciones->format('d-m-Y');
        $autoriza = auth()->user()->empleado->supervisor_id;
        $vacacion = new SolicitudVacaciones();
       
        $dias_disponibles = $this->diasDisponibles();
        $organizacion = Organizacion::first();
        $dias_pendientes = SolicitudVacaciones::where('empleado_id', '=', auth()->user()->empleado->id)->where('aprobacion', '=', 1)->where('año', '=', $año)->sum('dias_solicitados');

           // Funcion para dias dias disponibles año pasado
           $año_pasado = $this->diasDisponiblesAñopasado();
           if($año_pasado == 0){
               $mostrar_reclamo = false;
               $periodo_vencido = 0;
               $finVacaciones_periodo_pasado = null;
           }elseif($año_pasado > 0){
                    
               $periodo_vencido = $año-1;
               $finVacaciones_periodo_pasado = $inicio_vacaciones->addMonths(6);
               $finVacaciones_periodo_pasado =$finVacaciones_periodo_pasado->subYear();
            //    $finVacaciones_periodo_pasado = $finVacaciones_periodo_pasado->format('d-m-Y');

            //    $mostrar_reclamo = true;
              
            
               if( $finVacaciones_periodo_pasado >= $dia_hoy){
                $mostrar_reclamo = true;
                $finVacaciones_periodo_pasado = $finVacaciones_periodo_pasado->format('d-m-Y');
               }else{
                $mostrar_reclamo = false;
               }
            //    dd($mostrar_reclamo);
           }else{
               $mostrar_reclamo = false;
               $periodo_vencido = 0;
               $finVacaciones_periodo_pasado = null;
           }
          

        return view('admin.solicitudVacaciones.create', compact('vacacion', 'dias_disponibles', 'año', 'autoriza', 'no_vacaciones', 'organizacion', 'finVacaciones', 'dias_pendientes', 'tipo_conteo','mostrar_reclamo','periodo_vencido','año_pasado','finVacaciones_periodo_pasado'));
    }

    public function periodoAdicional()
    {
       
        $ingreso = auth()->user()->empleado->antiguedad;
        $dia_hoy = Carbon::now();
        $no_vacaciones = $ingreso->format('d-m-Y');
        $año = Carbon::createFromDate($ingreso)->age;
        $seis_meses = ($dia_hoy->diffInMonths($ingreso));
        // dd($seis_meses);
        $año = $año-1;      
        //  Determina si existe regla asociada
        $existe_regla_por_area = Vacaciones::where('inicio_conteo', '=', $año)->whereHas('areas', function ($q) {
            $q->where('area_id', auth()->user()->empleado->area_id);
        })->select('dias', 'tipo_conteo')->exists();
        $existe_regla_toda_empresa = Vacaciones::where('inicio_conteo', $año)->where('afectados', 1)->select('dias', 'tipo_conteo')->exists();

        
            if ($existe_regla_toda_empresa) {
                $regla_aplicada = Vacaciones::where('inicio_conteo', $año)->where('afectados', 1)->select('dias', 'tipo_conteo')->first();
            } elseif ($existe_regla_por_area) {
                $regla_aplicada = Vacaciones::where('inicio_conteo', '=', $año)->whereHas('areas', function ($q) {
                    $q->where('area_id', auth()->user()->empleado->area_id);
                })->select('dias', 'tipo_conteo')->first();
            } else {
                Flash::error('Regla de vacaciones no asociada');
                return redirect(route('admin.solicitud-vacaciones.index'));
            }
           


        $tipo_conteo = $regla_aplicada->tipo_conteo;
        $fecha_limite = Vacaciones::where('inicio_conteo', '=', $año)->pluck('fin_conteo')->first();
        $inicio_vacaciones = $ingreso->addYear();
        $finVacaciones = $inicio_vacaciones->addYear($año);
        $finVacaciones = $finVacaciones->format('d-m-Y');
        $autoriza = auth()->user()->empleado->supervisor_id;
        $vacacion = new SolicitudVacaciones();
        $dias_disponibles = $this->diasDisponiblesAñopasado();
        $organizacion = Organizacion::first();
        $dias_pendientes = SolicitudVacaciones::where('empleado_id', '=', auth()->user()->empleado->id)->where('aprobacion', '=', 1)->where('año', '=', $año)->sum('dias_solicitados');

          

        return view('admin.solicitudVacaciones.periodoAdicional', compact('vacacion', 'dias_disponibles', 'año', 'autoriza', 'no_vacaciones', 'organizacion', 'finVacaciones', 'dias_pendientes', 'tipo_conteo'));
    }


    public function store(Request $request)
    {
        abort_if(Gate::denies('solicitud_vacaciones_crear'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
            'empleado_id' => 'required|int',
            'dias_solicitados' => 'required|int',
            'año' => 'required|int',
            'autoriza' => 'required|int',
        ]);
        $supervisor = Empleado::find($request->autoriza);
        $solicitante = Empleado::find($request->empleado_id);

        $solicitud = SolicitudVacaciones::create($request->all());
        Mail::to($supervisor->email)->send(new MailSolicitudVacaciones($solicitante, $supervisor, $solicitud));

        Flash::success('Solicitud creada satisfactoriamente.');

        return redirect()->route('admin.solicitud-vacaciones.index');
    }


    public function show($id)
    {
        abort_if(Gate::denies('solicitud_vacaciones_acceder'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vacacion = SolicitudVacaciones::with('empleado')->find($id);

        if (empty($vacacion)) {
            Flash::error('Vacación not found');
            return redirect(route('admin.solicitud-vacaciones.index'));
        }



        return view('admin.solicitudVacaciones.show', compact('vacacion'));
    }


    public function edit($id)
    {
    }


    public function update(Request $request, $id)
    {
        abort_if(Gate::denies('solicitud_vacaciones_aprobar'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
            'empleado_id' => 'required|int',
            'dias_solicitados' => 'required|int',
            'año' => 'required|int',
            'autoriza' => 'required|int',
            'aprobacion' => 'required|int',
        ]);

        $solicitud = SolicitudVacaciones::find($id);
        $supervisor = Empleado::find($request->autoriza);
        $solicitante = Empleado::find($request->empleado_id);

        $solicitud->update($request->all());

        Mail::to($solicitante->email)->send(new MailRespuestaVacaciones($solicitante, $supervisor, $solicitud));
        Flash::success('Respuesta enviada satisfactoriamente.');

        return redirect(route('admin.solicitud-vacaciones.aprobacion'));
    }


    public function destroy(Request $request)
    {
        abort_if(Gate::denies('solicitud_vacaciones_eliminar'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $id = $request->id;
        $vacaciones = SolicitudVacaciones::find($id);
        $vacaciones->delete();

        return response()->json(['status' => 200]);
    }

    public function massDestroy(Request $request)
    {
        SolicitudVacaciones::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function diasDisponibles()
    {

        $ingreso = auth()->user()->empleado->antiguedad;
        $año = Carbon::createFromDate($ingreso)->age;

        if ($año == 0) {
            $medio_año = true;
            $año = 1;
        }else{
            $medio_año =false;
        }

        if ($año >= 1) {
            $dias_otorgados = Vacaciones::where('inicio_conteo', '=', $año)->pluck('dias')->first();
            $dias_extra = IncidentesVacaciones::where('efecto', 1)->where('aniversario', $año)->whereHas('empleados', function ($q) {
                $q->where('empleado_id', auth()->user()->empleado->id);
            })->pluck('dias_aplicados')->sum();
            $dias_restados = IncidentesVacaciones::where('efecto', 2)->where('aniversario', $año)->whereHas('empleados', function ($q) {
                $q->where('empleado_id', auth()->user()->empleado->id);
            })->pluck('dias_aplicados')->sum();

            $dias_gastados = SolicitudVacaciones::where('empleado_id', auth()->user()->empleado->id)->where('año', '=', $año)->where(function ($query) {
                $query->where('aprobacion', '=', 1)
                    ->orwhere('aprobacion', '=', 3);
            })->sum('dias_solicitados');

            if($medio_año == true){
                $dias_otorgados = $dias_otorgados/2;
            }

            $dias_disponibles = $dias_otorgados - $dias_gastados + $dias_extra - $dias_restados;
            return $dias_disponibles;
        } else {
            return null;
        }
    }

    public function diasDisponiblesAñopasado()
    {
        $ingreso = auth()->user()->empleado->antiguedad;
        $año_actual = Carbon::createFromDate($ingreso)->age;
        $año = $año_actual-1;
 
        if ($año >= 1) {
            $dias_otorgados = Vacaciones::where('inicio_conteo', '=', $año)->pluck('dias')->first();
            $dias_extra = IncidentesVacaciones::where('efecto', 1)->where('aniversario', $año)->whereHas('empleados', function ($q) {
                $q->where('empleado_id', auth()->user()->empleado->id);
            })->pluck('dias_aplicados')->sum();
            $dias_restados = IncidentesVacaciones::where('efecto', 2)->where('aniversario', $año)->whereHas('empleados', function ($q) {
                $q->where('empleado_id', auth()->user()->empleado->id);
            })->pluck('dias_aplicados')->sum();

            $dias_gastados = SolicitudVacaciones::where('empleado_id', auth()->user()->empleado->id)->where('año', '=', $año)->where(function ($query) {
                $query->where('aprobacion', '=', 1)
                    ->orwhere('aprobacion', '=', 3);
            })->sum('dias_solicitados');
            $dias_disponibles = $dias_otorgados - $dias_gastados + $dias_extra - $dias_restados;
            return $dias_disponibles;
        } else {
            return null;
        }
      
    }

    

    public function aprobacionMenu(Request $request)
    {
        abort_if(Gate::denies('modulo_aprobacion_ausencia'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $solicitud_vacacion = SolicitudVacaciones::where('autoriza', auth()->user()->empleado->id)->where('aprobacion', 1)->count();
        $solicitud_dayoff = SolicitudDayOff::where('autoriza', auth()->user()->empleado->id)->where('aprobacion', 1)->count();
        $solicitud_permiso = SolicitudPermisoGoceSueldo::where('autoriza', auth()->user()->empleado->id)->where('aprobacion', 1)->count();
        $solicitudes_pendientes = $solicitud_vacacion + $solicitud_dayoff + $solicitud_permiso;
        return view('admin.solicitudVacaciones.aprobacion-menu', compact('solicitud_dayoff', 'solicitud_vacacion', 'solicitud_permiso'));
    }


    public function aprobacion(Request $request)
    {
        abort_if(Gate::denies('modulo_aprobacion_ausencia'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $data = auth()->user()->empleado->id;

        if ($request->ajax()) {
            $query = SolicitudVacaciones::with('empleado')->where('autoriza', '=', $data)->where('aprobacion', '=', 1)->orderByDesc('id')->get();
            $table = datatables()::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('empleado', function ($row) {
                return $row->empleado ? $row->empleado : '';
            });

            $table->editColumn('dias_solicitados', function ($row) {
                return $row->dias_solicitados ? $row->dias_solicitados : '';
            });
            $table->editColumn('fecha_inicio', function ($row) {
                return $row->fecha_inicio ? $row->fecha_inicio : '';
            });
            $table->editColumn('fecha_fin', function ($row) {
                return $row->fecha_fin ? $row->fecha_fin : '';
            });
            $table->editColumn('aprobacion', function ($row) {
                return $row->aprobacion ? $row->aprobacion  : '';
            });
            // $table->editColumn('descripcion', function ($row) {
            //     return $row->descripcion ? $row->descripcion : '';
            // });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }
        $organizacion_actual = Organizacion::select('empresa', 'logotipo')->first();
        if (is_null($organizacion_actual)) {
            $organizacion_actual = new Organizacion();
            $organizacion_actual->logotipo = asset('img/logo.png');
            $organizacion_actual->empresa = 'Silent4Business';
        }
        $logo_actual = $organizacion_actual->logotipo;
        $empresa_actual = $organizacion_actual->empresa;
        return view('admin.solicitudVacaciones.global-solicitudes', compact('logo_actual', 'empresa_actual'));
    }


    public function respuesta($id)
    {

        abort_if(Gate::denies('modulo_aprobacion_ausencia'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $vacacion = SolicitudVacaciones::with('empleado')->find($id);

        if (empty($vacacion)) {
            Flash::error('Vacación not found');

            return redirect(route('admin.solicitud-vacaciones.index'));
        }
        $solicitante = $vacacion->empleado_id;
        $ingreso = Empleado::where('id', $solicitante)->pluck('antiguedad')->first();
        $año = Carbon::createFromDate($ingreso)->age;
        if ($año >= 1) {
            $dias_otorgados = Vacaciones::where('inicio_conteo', '=', $año)->pluck('dias')->first();
            $dias_gastados = SolicitudVacaciones::where('año', '=', $año)->where('aprobacion', '=', '3')->sum('dias_solicitados');
            $dias_disponibles = $dias_otorgados - $dias_gastados;
        } else {
            $dias_disponibles = null;
        }

        return view('admin.solicitudVacaciones.respuesta', compact('vacacion', 'dias_disponibles', 'año'));
    }

    public function archivo(Request $request)
    {

        abort_if(Gate::denies('modulo_aprobacion_ausencia'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $data = auth()->user()->empleado->id;

        if ($request->ajax()) {
            $query = SolicitudVacaciones::with('empleado')->where('autoriza', '=', $data)->where(function ($query) {
                $query->where('aprobacion', '=', 2)
                    ->orwhere('aprobacion', '=', 3);
            })->orderByDesc('id')->get();
            $table = datatables()::of($query);
            $table->editColumn('actions', function ($row) {
                $viewGate = 'amenazas_ver';
                $editGate = 'amenazas_editar';
                $deleteGate = 'amenazas_eliminar';
                $crudRoutePart = 'solicitud-vacaciones';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('empleado', function ($row) {
                return $row->empleado ? $row->empleado : '';
            });
            $table->editColumn('dias_solicitados', function ($row) {
                return $row->dias_solicitados ? $row->dias_solicitados : '';
            });
            $table->editColumn('fecha_inicio', function ($row) {
                return $row->fecha_inicio ? $row->fecha_inicio : '';
            });
            $table->editColumn('fecha_fin', function ($row) {
                return $row->fecha_fin ? $row->fecha_fin : '';
            });
            $table->editColumn('aprobacion', function ($row) {
                return $row->aprobacion ? $row->aprobacion : '';
            });

            $table->rawColumns(['actions', 'placeholder']);
            return $table->make(true);
        }
        $organizacion_actual = Organizacion::select('empresa', 'logotipo')->first();
        if (is_null($organizacion_actual)) {
            $organizacion_actual = new Organizacion();
            $organizacion_actual->logotipo = asset('img/logo.png');
            $organizacion_actual->empresa = 'Silent4Business';
        }
        $logo_actual = $organizacion_actual->logotipo;
        $empresa_actual = $organizacion_actual->empresa;
        return view('admin.solicitudVacaciones.archivo', compact('logo_actual', 'empresa_actual'));
    }
    public function showVistaGlobal($id)
    {
        abort_if(Gate::denies('reglas_vacaciones_vista_global'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $vacacion = SolicitudVacaciones::with('empleado')->find($id);

        if (empty($vacacion)) {
            Flash::error('Vacación not found');
            return redirect(route('admin.solicitud-vacaciones.index'));
        }
        return view('admin.solicitudVacaciones.vistaGlobal', compact('vacacion'));
    }

    public function archivoShow($id)
    {
        
        abort_if(Gate::denies('modulo_aprobacion_ausencia'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $vacacion = SolicitudVacaciones::with('empleado')->find($id);

        if (empty($vacacion)) {
            Flash::error('Vacación not found');
            return redirect(route('admin.solicitud-vacaciones.index'));
        }
        return view('admin.solicitudVacaciones.archivoShow', compact('vacacion'));
    }
}
