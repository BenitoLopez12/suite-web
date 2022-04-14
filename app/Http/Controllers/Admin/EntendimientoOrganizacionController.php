<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyEntendimientoOrganizacionRequest;
use App\Models\AmenazasEntendimientoOrganizacion;
use App\Models\DebilidadesEntendimientoOrganizacion;
use App\Models\Empleado;
use App\Models\EntendimientoOrganizacion;
use App\Models\FortalezasEntendimientoOrganizacion;
use App\Models\OportunidadesEntendimientoOrganizacion;
use App\Models\Team;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class EntendimientoOrganizacionController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('entendimiento_organizacion_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        //$obtener_FODA = EntendimientoOrganizacion::first();
        // $query = EntendimientoOrganizacion::with('empleado')->get();
        // dd($query);
        if ($request->ajax()) {
            $query = EntendimientoOrganizacion::with('empleado', 'participantes')->orderByDesc('id')->get();
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'entendimiento_organizacion_show';
                $editGate = 'entendimiento_organizacion_edit';
                $deleteGate = 'entendimiento_organizacion_delete';
                $crudRoutePart = 'entendimiento-organizacions';

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
            $table->editColumn('fortaleza', function ($row) {
                return $row->fortaleza ? strip_tags($row->fortaleza) : '';
            });
            $table->editColumn('oportunidades', function ($row) {
                return $row->oportunidades ? $row->oportunidades : '';
            });
            $table->editColumn('debilidades', function ($row) {
                return $row->debilidades ? $row->debilidades : '';
            });
            $table->editColumn('amenazas', function ($row) {
                return $row->amenazas ? $row->amenazas : '';
            });
            $table->editColumn('analisis', function ($row) {
                return $row->analisis ? $row->analisis : '';
            });
            $table->editColumn('fecha', function ($row) {
                return $row->fecha ? \Carbon\Carbon::parse($row->fecha)->format('d-m-Y') : '';
            });
            $table->editColumn('elabora', function ($row) {
                return $row->empleado ? $row->empleado->name : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        $obtener_FODA = EntendimientoOrganizacion::first();
        $empleado = Empleado::get();
        $teams = Team::get();

        return view('admin.entendimientoOrganizacions.index', compact('obtener_FODA', 'teams', 'empleado'));
    }

    public function create()
    {
        abort_if(Gate::denies('entendimiento_organizacion_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $entendimientoOrganizacion = new EntendimientoOrganizacion;
        $empleados = Empleado::get();
        $isEdit = false;
        $esta_vinculado = auth()->user()->empleado ? true : false;

        return view('admin.entendimientoOrganizacions.create', compact('isEdit', 'entendimientoOrganizacion', 'esta_vinculado', 'empleados'));
    }

    public function store(Request $request, EntendimientoOrganizacion $entendimientoOrganizacion)
    {
        $request->validate([

            'analisis' => 'required|string',
            'fecha' => 'required|string',
            'id_elabora' => 'required|string',

        ]);

        $foda = $entendimientoOrganizacion->create($request->all());
        // Almacenamiento de participantes relacionados
        $this->vincularParticipantes($request->participantes, $foda);

        return redirect()->route('admin.entendimiento-organizacions.edit', $foda)->with('success', 'Análisis FODA creado correctamente');
    }

    public function vincularParticipantes($participantesA, $model)
    {
        if(is_array($participantesA)){
            $participantes = $participantesA;
        }else{
            $arrstrParticipantes = explode(',', $participantesA);
            $participantes = array_map(function ($valor) {
                return intval($valor);
            }, $arrstrParticipantes);
        }

        // dd($participantes);
        $model->participantes()->sync($participantes);
    }

    public function edit(EntendimientoOrganizacion $entendimientoOrganizacion)
    {
        abort_if(Gate::denies('entendimiento_organizacion_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $entendimientoOrganizacion->load('participantes');

        $empleados = Empleado::get();

        $isEdit = true;

        $esta_vinculado = auth()->user()->empleado ? true : false;

        // $entendimiento->load('participantes');

        return view('admin.entendimientoOrganizacions.edit', compact('isEdit', 'entendimientoOrganizacion', 'esta_vinculado', 'empleados'));
    }

    public function update(Request $request, EntendimientoOrganizacion $entendimientoOrganizacion)
    {
        $request->validate([

            'analisis' => 'required|string',
            'fecha' => 'required|string',
            'id_elabora' => 'required|string',

        ]);

        $entendimientoOrganizacion->update($request->all());
        $this->vincularParticipantes($request->participantes, $entendimientoOrganizacion);

        return redirect()->route('admin.entendimiento-organizacions.index')->with('success', 'Análisis FODA actualizado correctamente');
    }

    public function show(EntendimientoOrganizacion $entendimientoOrganizacion)
    {
        abort_if(Gate::denies('entendimiento_organizacion_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $empleados = Empleado::get();
        $obtener_FODA = $entendimientoOrganizacion;
        $fortalezas = FortalezasEntendimientoOrganizacion::where('foda_id',$entendimientoOrganizacion->id)->get();
        $oportunidades = OportunidadesEntendimientoOrganizacion::where('foda_id',$entendimientoOrganizacion->id)->get();
        $amenazas = AmenazasEntendimientoOrganizacion::where('foda_id',$entendimientoOrganizacion->id)->get();
        $debilidades = DebilidadesEntendimientoOrganizacion::where('foda_id',$entendimientoOrganizacion->id)->get();

        return view('admin.entendimientoOrganizacions.show', compact('fortalezas', 'oportunidades', 'amenazas', 'debilidades', 'empleados', 'obtener_FODA'));
    }

    public function destroy(EntendimientoOrganizacion $entendimientoOrganizacion)
    {
        abort_if(Gate::denies('entendimiento_organizacion_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $entendimientoOrganizacion->delete();

        return back()->with('deleted', 'Registro eliminado con éxito');
    }

    public function massDestroy(MassDestroyEntendimientoOrganizacionRequest $request)
    {
        EntendimientoOrganizacion::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function duplicarFoda(Request $request){

        $fodaOld = EntendimientoOrganizacion::with('participantes','fodafortalezas','fodaoportunidades','fodadebilidades','fodamenazas')->find($request->id);
        $participantes = $fodaOld->participantes->pluck('id')->toArray();
        $fortalezas=$fodaOld->fodafortalezas;
        $oportunidades=$fodaOld->fodaoportunidades;
        $debilidades=$fodaOld->fodadebilidades;
        $amenazas=$fodaOld->fodamenazas;

        $foda = EntendimientoOrganizacion::create([
            'analisis'=>$fodaOld->analisis,
            'fecha'=>$fodaOld->fecha,
            'id_elabora'=>$fodaOld->id_elabora,
        ]);
        // Almacenamiento de participantes relacionados
        $this->vincularParticipantes($participantes, $foda);
        foreach($fortalezas as $fortaleza){
            FortalezasEntendimientoOrganizacion::create([
                'foda_id' => $foda->id,
                'fortaleza' => $fortaleza->fortaleza,
                'riesgo' => $fortaleza->riesgo,
            ]);
        }

        foreach($oportunidades as $oportunidad){
            OportunidadesEntendimientoOrganizacion::create([
                'foda_id' => $foda->id,
                'oportunidad' => $oportunidad->oportunidad,
                'riesgo' => $oportunidad->riesgo,
            ]);
        }

        foreach($debilidades as $debilidad){
            DebilidadesEntendimientoOrganizacion::create([
                'foda_id' => $foda->id,
                'debilidad' => $debilidad->debilidad,
                'riesgo' => $debilidad->riesgo,
            ]);
        }

        foreach($amenazas as $amenaza){
            AmenazasEntendimientoOrganizacion::create([
                'foda_id' => $foda->id,
                'amenaza' => $amenaza->amenaza,
                'riesgo' => $amenaza->riesgo,
            ]);
        }

        return response()->json(['success' => true,'id'=>$foda->id]);
    }

    // public function edit()
    // {
    //     abort_if(Gate::denies('entendimiento_organizacion_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    //     return view('admin.entendimiento-organizacion.edit');
    // }

    // public function massDestroy(MassDestroyAreaRequest $request)
    // {
    //     Area::whereIn('id', request('ids'))->delete();

    //     return response(null, Response::HTTP_NO_CONTENT);
    // }
}
