<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyComiteseguridadRequest;
use App\Http\Requests\UpdateComiteseguridadRequest;
use App\Models\Comiteseguridad;
use App\Models\Empleado;
use App\Models\MiembrosComiteSeguridad;
use App\Models\Organizacion;
use App\Models\Team;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ComiteseguridadController extends Controller
{
    public function index(Request $request)
    {
        // $query = Comiteseguridad::with(['personaasignada', 'team','asignacion'])->select(sprintf('%s.*', (new Comiteseguridad)->table))->get();
        // dd($query[2]->asignacion->avatar);
        abort_if(Gate::denies('comformacion_comite_seguridad_acceder'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            // $query = Comiteseguridad::with(['personaasignada', 'team', 'asignacion'])->select(sprintf('%s.*', (new Comiteseguridad)->table))->orderByDesc('id');
            $query = Comiteseguridad::with('miembros')->orderByDesc('id')->get();
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'comformacion_comite_seguridad_ver';
                $editGate = 'comformacion_comite_seguridad_editar';
                $deleteGate = 'comformacion_comite_seguridad_eliminar';
                $crudRoutePart = 'comiteseguridads';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            // $table->editColumn('id', function ($row) {
            //     return $row->id ? $row->id : '';
            // });
            $table->editColumn('nombre_comite', function ($row) {
                return $row->nombre_comite ? $row->nombre_comite : '';
            });
            $table->addColumn('descripcion', function ($row) {
                return $row->descripcion ? $row->descripcion : '';
            });
            // $table->editColumn('responsabilidades', function ($row) {
            //     return $row->responsabilidades ? $row->responsabilidades : '';
            // });
            // $table->editColumn('fechavigor', function ($row) {
            //     return $row->fechavigor ? $row->fechavigor : '';
            // });

            $table->rawColumns(['actions', 'placeholder', 'personaasignada']);

            return $table->make(true);
        }

        $users = User::get();
        $teams = Team::get();

        return view('admin.comiteseguridads.index', compact('users', 'teams'));
    }

    public function create()
    {
        abort_if(Gate::denies('comformacion_comite_seguridad_agregar'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        // $personaasignadas = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        // $empleados = Empleado::alta()->with('area')->get();
        // return view('admin.comiteseguridads.create', compact('personaasignadas', 'empleados'));
        $id = new Comiteseguridad();
        return view('admin.comiteseguridads.create', compact('id'));
        
    }

    public function store(Request $request)
    {
        // abort_if(Gate::denies('comformacion_comite_seguridad_agregar'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        // $comiteseguridad = Comiteseguridad::create($request->all());
        // // dd($comiteseguridad);
        // return redirect()->route('admin.comiteseguridads.index')->with('success', 'Guardado con éxito');
       
        $comiteseguridad = Comiteseguridad::create($request->all());
        // $id = $request->id;
     
        
        return redirect()->route('admin.comiteseguridads.edit', ['comiteseguridad'=>$comiteseguridad]);
    }

    public function edit(Request $request, $comiteseguridad)
    {
        abort_if(Gate::denies('comformacion_comite_seguridad_editar'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $comiteseguridad= Comiteseguridad::find($comiteseguridad);
        // $personaasignadas = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        // $comiteseguridad->load('team');
        // $empleados = Empleado::alta()->with('area')->get();
        // return view('admin.comiteseguridads.edit', compact('personaasignadas', 'comiteseguridad', 'empleados'));

        return view('admin.comiteseguridads.edit',compact('comiteseguridad'));
    }

    public function update(UpdateComiteseguridadRequest $request, Comiteseguridad $comiteseguridad)
    {
        abort_if(Gate::denies('comformacion_comite_seguridad_editar'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $comiteseguridad->update($request->all());

        return redirect()->route('admin.comiteseguridads.index')->with('success', 'Editado con éxito');
    }

    public function show(Comiteseguridad $comiteseguridad)
    {
        abort_if(Gate::denies('comformacion_comite_seguridad_ver'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        // dd($comiteseguridad);
        $datas = MiembrosComiteSeguridad::where('comite_id', '=', $comiteseguridad->id)->with('asignacion')->get();
     
        $comiteseguridad->load('miembros');

        return view('admin.comiteseguridads.show', compact('comiteseguridad','datas'));
    }

    public function destroy(Comiteseguridad $comiteseguridad)
    {
        abort_if(Gate::denies('comformacion_comite_seguridad_eliminar'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $comiteseguridad->delete();

        return back()->with('deleted', 'Registro eliminado con éxito');
    }

    public function massDestroy(MassDestroyComiteseguridadRequest $request)
    {
        Comiteseguridad::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function visualizacion()
    {
        $comiteseguridads = Comiteseguridad::get();
        // dd($comiteseguridads);

        $organizacion = Organizacion::get();

        return view('admin.comiteseguridads.visualizacion', compact('comiteseguridads', 'organizacion'));
    }
}
