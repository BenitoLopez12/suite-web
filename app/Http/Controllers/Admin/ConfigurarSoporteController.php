<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyConfiguracionSoporteRequest;
use App\Models\ConfigurarSoporteModel;
use App\Models\Empleado;
use App\Models\Puesto;
use Composer\Util\Http\Response;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ConfigurarSoporteController extends Controller
{
    public function index(Request $request)
    {
        // $query = ConfigurarSoporteModel::with(['empleado'])->select('*')->orderByDesc('id')->get();
        // dd($query);
        if ($request->ajax()) {
            $query = ConfigurarSoporteModel::with(['empleado'])->select('*')->orderByDesc('id')->get();
            // dd($query);
            $table = Datatables::of($query);
            // dd($table);
            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'partes_interesada_show';
                $editGate = 'partes_interesada_edit';
                $deleteGate = 'partes_interesada_delete';
                $crudRoutePart = 'configurar-soporte';

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
            $table->editColumn('rol', function ($row) {
                return $row->rol ? $row->rol : '';
            });
            $table->editColumn('id_elaboro', function ($row) {
                return $row->Empleado->name ? $row->Empleado->name : '';
            });

            $table->editColumn('puesto', function ($row) {
                return $row->Empleado->getPuestoAttribute() ? $row->Empleado->getPuestoAttribute() : '';
            });
            $table->editColumn('telefono', function ($row) {
                return $row->telefono ? $row->telefono : '';
            });
            $table->editColumn('extension', function ($row) {
                return $row->extension ? $row->extension : '';
            });
            $table->editColumn('tel_celular', function ($row) {
                return $row->tel_celular ? $row->tel_celular : '';
            });
            $table->editColumn('correo', function ($row) {
                return $row->correo ? $row->correo : '';
            });
            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        // $ConfigurarSoporteModel = ConfigurarSoporteModel::get();
        // dd($ConfigurarSoporteModel);

        $ConfigurarSoporteModel = ConfigurarSoporteModel::join('empleados', 'empleados.id', '=', 'configuracion_soporte.id_elaboro')
        ->join('puestos', 'puestos.id', '=', 'empleados.puesto_id')
        ->get();

        // dd($ConfigurarSoporteModel);
        // $ConfigurarSoporteModel = ConfigurarSoporteModel::join('empleados', 'empleados.id', '=', 'configuracion_soporte.puesto')->get();

        return view('admin.confSoporte.index', compact('ConfigurarSoporteModel'));
    }

    public function create()
    {
        $ConfigurarSoporteModel = ConfigurarSoporteModel::all();
        $empleados = Empleado::get();
        $puestos = Puesto::get();

        return view('admin.confSoporte.create', compact('ConfigurarSoporteModel', 'empleados', 'puestos'));
    }

    // StorePartesInteresadaRequest
    public function store(Request $request)
    {
        // dd($request->all());
        // $ConfigurarSoporteModel = ConfigurarSoporteModel::create($request->all());
        $ConfigurarSoporteModel = ConfigurarSoporteModel::create([
            'rol' => $request->rol,
            'puesto' => $request->puesto,
            'telefono' => $request->telefono,
            'extension' => $request->extension,
            'tel_celular' => $request->tel_celular,
            'correo' => $request->correo,
            'id_elaboro' =>  $request->id_elaboro,
        ]);
        // $ConfigurarSoporteModel= new ConfigurarSoporteModel;
        // $ConfigurarSoporteModel->puesto = $request->puesto;
        // $ConfigurarSoporteModel->save();

        return redirect()->route('admin.configurar-soporte.index')->with('success', 'Guardado con éxito');
    }

    public function edit($ConfigurarSoporteModel)
    {
        // dd($ConfigurarSoporteModel);
        $ConfigurarSoporteModel = ConfigurarSoporteModel::find($ConfigurarSoporteModel);
        // dd($ConfigurarSoporteModel);
        $empleados = Empleado::get();
        $puestos = Puesto::get();

        return view('admin.confSoporte.edit', compact('ConfigurarSoporteModel', 'empleados', 'puestos'));
    }

    // public function show(ConfigurarSoporteModel $ConfigurarSoporteModel)
    // {
    //     // abort_if(Gate::denies('partes_interesada_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    //     $ConfigurarSoporteModel->load('ConfigurarSoporteModel');

    //     return view('admin.confSoporte.show', compact('ConfigurarSoporteModel'));
    // }

    // UpdatePartesInteresadaRequest
    public function update(Request $request, ConfigurarSoporteModel $ConfigurarSoporteModel)
    {
        // dd($request);
        $ConfigurarSoporteModel->update($request->all());

        return redirect()->route('admin.configurar-soporte.index')->with('success', 'Editado con éxito');
    }

    public function destroy($ConfigurarSoporteModel)
    {

        // abort_if(Gate::denies('partes_interesada_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ConfigurarSoporteModel = ConfigurarSoporteModel::find($ConfigurarSoporteModel);
        // dd($ConfigurarSoporteModel);

        $ConfigurarSoporteModel->delete();

        return back()->with('deleted', 'Registro eliminado con éxito');
    }

    public function massDestroy(MassDestroyConfiguracionSoporteRequest $request)
    {
        ConfigurarSoporteModel::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function visualizarSoporte(Request $request)
    {
        $ConfigurarSoporteModel = ConfigurarSoporteModel::join('empleados', 'empleados.id', '=', 'configuracion_soporte.id_elaboro')
        ->join('puestos', 'puestos.id', '=', 'empleados.puesto_id')
        ->get();

        return view('admin.soporte.index', compact('ConfigurarSoporteModel'));
    }

    public function getgetEmployeeData(Request $request)
    {
        // return response()->json(['test' => 'test']);
        $empleados = Empleado::find($request->id);
        // dd($empleados);
        // return response()->json([$empleados->extension]);
        return response()->json(['id_puesto' => $empleados->id, 'puesto' => $empleados->puesto, 'telefono' => $empleados->telefono, 'extension' => $empleados->extension, 'telefono_movil' => $empleados->telefono_movil, 'email' => $empleados->email]);
    }
}
