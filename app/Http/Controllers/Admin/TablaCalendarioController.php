<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use Illuminate\Http\Request;
use App\Models\Calendario;
use Composer\Util\Http\Response;
use Laracasts\Flash\Flash;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\FechaRepository;

class TablaCalendarioController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Calendario::orderByDesc('id')->get();
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'user_show';
                $editGate = 'user_edit';
                $deleteGate = 'user_delete';
                $crudRoutePart = 'tabla-calendario';

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
            $table->editColumn('nombre', function ($row) {
                return $row->nombre ? $row->nombre : '';
            });
            $table->editColumn('fecha', function ($row) {
                return $row->fecha ? $row->fecha : '';
            });
            $table->editColumn('categoria', function ($row) {
                return $row->categoria ? $row->categoria : '';
            });
            $table->editColumn('descripcion', function ($row) {
                return $row->descripcion ? $row->descripcion : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }
        return view('admin.tabla-calendario.index');
    }


    public function create(Request $request)
    {
        $calendario=new Calendario();
        return view('admin.tabla-calendario.create', compact("calendario"));
    }

    public function store(Request $request)
    {
        $fecha = Calendario::create($request->all());
        return redirect(route('admin.tabla-calendario.index'))->with(["success"=>"Registro guardado con exito"]);
    }

    public function show(Calendario $calendario)
    {
       // abort_if(Gate::denies('enlaces_ejecutar_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

       return view('admin.tabla-calendario.show', compact('calendario'));
    }

    public function edit(Calendario $calendario)
    {
        return view('admin.tabla-calendario.edit',compact("calendario"));
    }

    public function update(Request $request, Calendario $calendario)
    {
        $fecha = $calendario->update($request->all());

        return redirect(route('admin.tabla-calendario.index'))->with(["success"=>"Registro Actualizado"]);
    }

    public function destroy(Calendario $calendario)
    {
        $calendario->delete();

        return redirect(route('admin.tabla-calendario.index'))->with(["success"=>"Registro Eliminado"]);
    }

}



