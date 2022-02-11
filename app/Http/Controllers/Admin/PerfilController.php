<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Empleado;
use App\Models\PerfilEmpleado;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Response;

class PerfilController extends Controller
{
    public function index(Request $request)
    {
        abort_if('niveles_jerarquicos_access', Response::HTTP_FORBIDDEN, '403 Forbidden');
        if ($request->ajax()) {
            $query = PerfilEmpleado::with(['empleados'])->orderBy('id')->get();
            $table = DataTables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'niveles_jerarquicos_create';
                $editGate = 'niveles_jerarquicos_edit';
                $deleteGate = 'niveles_jerarquicos_delete';
                $crudRoutePart = 'perfiles';

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
            $table->editColumn('perfil', function ($row) {
                return $row->nombre ? $row->nombre : '';
            });
            $table->editColumn('descripcion', function ($row) {
                return $row->descripcion ? $row->descripcion : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'activo_id', 'controles']);

            return $table->make(true);
        }

        return view('admin.perfiles.index');
    }

    public function create()
    {
        abort_if('niveles_jerarquicos_create', Response::HTTP_FORBIDDEN, '403 Forbidden');
        $empleados = Empleado::get();

        return view('admin.perfiles.create', compact('empleados'));
    }

    public function store(Request $request)
    {
        abort_if('niveles_jerarquicos_create', Response::HTTP_FORBIDDEN, '403 Forbidden');

        $perfil = PerfilEmpleado::create($request->all());

        return redirect()->route('admin.perfiles.index')->with('success', 'Guardado con éxito');
    }

    public function edit($perfil)
    {
        abort_if('niveles_jerarquicos_edit', Response::HTTP_FORBIDDEN, '403 Forbidden');
        $perfil = PerfilEmpleado::find($perfil);

        return view('admin.perfiles.edit', compact('perfil'));
    }

    public function update(Request $request, $perfil)
    {
        abort_if('niveles_jerarquicos_edit', Response::HTTP_FORBIDDEN, '403 Forbidden');
        $perfil = PerfilEmpleado::find($perfil);
        $perfil->update($request->all());

        return redirect()->route('admin.perfiles.index')->with('success', 'Editado con éxito');
    }

    public function show($perfil)
    {
        abort_if('niveles_jerarquicos_show', Response::HTTP_FORBIDDEN, '403 Forbidden');
        $perfil = PerfilEmpleado::find($perfil);

        return view('admin.perfiles.show', compact('perfil'));
    }

    public function destroy($perfil)
    {
        abort_if('niveles_jerarquicos_delete', Response::HTTP_FORBIDDEN, '403 Forbidden');
        $perfil = PerfilEmpleado::find($perfil);
        // dd($perfil);
        $perfil->delete();

        return back()->with('deleted', 'Registro eliminado con éxito');
    }
}
