<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Empleado;
use App\Models\IncidentesDayoff;
use App\Models\Organizacion;
use Carbon\Carbon;
use Flash;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class IncidentesDayOffController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('incidentes_dayoff_acceder'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if ($request->ajax()) {
            $query = IncidentesDayoff::with('empleados')->orderByDesc('id')->get();
            $table = datatables()::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'amenazas_ver';
                $editGate = 'amenazas_editar';
                $deleteGate = 'amenazas_eliminar';
                $crudRoutePart = 'incidentes-dayoff';

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
            $table->editColumn('dias_aplicados', function ($row) {
                return $row->dias_aplicados ? $row->dias_aplicados : '';
            });
            $table->editColumn('aniversario', function ($row) {
                return $row->aniversario ? $row->aniversario : '';
            });
            $table->editColumn('efecto', function ($row) {
                return $row->efecto ? $row->efecto : '';
            });

            $table->editColumn('descripcion', function ($row) {
                return $row->descripcion ? $row->descripcion : '';
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

        return view('admin.incidentesDayoff.index', compact('logo_actual', 'empresa_actual'));
    }

    public function create()
    {
        abort_if(Gate::denies('incidentes_dayoff_crear'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $vacacion = new IncidentesDayOff();
        $empleados = Empleado::get();
        $empleados_seleccionados = $vacacion->empleados->pluck('id')->toArray();
        $año = Carbon:: now()->format('Y');

        return view('admin.incidentesDayoff.create', compact('vacacion', 'empleados', 'empleados_seleccionados', 'año'));
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('incidentes_dayoff_crear'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'nombre' => 'required|string',
            'dias_aplicados' => 'required|int',
            'aniversario' => 'required|int',
            'efecto' => 'required|int',
        ]);

        $empleados = array_map(function ($value) {
            return intval($value);
        }, $request->empleados);
        $vacacion = IncidentesDayOff::create($request->all());
        $vacacion->empleados()->sync($empleados);

        Flash::success('Incidencia añadida satisfactoriamente.');

        return redirect()->route('admin.incidentes-dayoff.index');
    }

    public function show($id)
    {
        abort_if(Gate::denies('incidentes_dayoff_acceder'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $vacacion = IncidentesDayoff::with('empleados')->find($id);

        return view('admin.incidentesDayoff.show', compact('vacacion'));
    }

    public function edit($id)
    {
        abort_if(Gate::denies('incidentes_dayoff_editar'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $empleados = Empleado::get();
        $vacacion = IncidentesDayoff::with('empleados')->find($id);
        if (empty($vacacion)) {
            Flash::error('Excepción not found');

            return redirect(route('admin.incidentes-dayoff'));
        }
        $empleados_seleccionados = $vacacion->empleados->pluck('id')->toArray();

        return view('admin.incidentesDayoff.edit', compact('vacacion', 'empleados', 'empleados_seleccionados'));
    }

    public function update(Request $request, $id)
    {
        abort_if(Gate::denies('incidentes_dayoff_editar'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'nombre' => 'required|string',
            'dias_aplicados' => 'required|int',
            'aniversario' => 'required|int',
            'efecto' => 'required|int',
        ]);

        $vacacion = IncidentesDayoff::find($id);

        $vacacion->update($request->all());
        $empleados = array_map(function ($value) {
            return intval($value);
        }, $request->empleados);
        $vacacion->empleados()->sync($empleados);

        Flash::success('Excepción de Day Off actualizada.');

        return redirect(route('admin.incidentes-dayoff.index'));
    }

    public function destroy($id)
    {
        abort_if(Gate::denies('incidentes_dayoff_eliminar'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $vacaciones = IncidentesDayoff::find($id);
        $vacaciones->delete();

        return back()->with('deleted', 'Registro eliminado con éxito');
    }
}
