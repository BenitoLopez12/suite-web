<?php


namespace App\Http\Controllers\Admin;

use Gate;
use App\Models\Team;
use App\Models\Grupo;
use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\StoreGrupoRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyGrupoAreaRequest;
use App\Models\Area;

class GrupoAreaController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {

        abort_if(Gate::denies('configuracion_grupoarea_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if ($request->ajax()) {
            $grupos = Grupo::get();
            return datatables()->of($grupos)->toJson();
        }

        return view('admin.grupoarea.index');
    }

    public function create()
    {
        abort_if(Gate::denies('configuracion_grupoarea_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.grupoarea.create');
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'nombre' => 'required|string',
                'descripcion' => 'required|string',
            ],
        );

        $grupoarea = Grupo::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'color' => $request->color,
            // 'color' => sprintf('#%06X', mt_rand(0, 0xFFFFFF)),
        ]);
        // Flash::success('<h5 class="text-center">Grupo agregado satisfactoriamente</h5>');
        return redirect()->route('admin.grupoarea.index')->with("success", 'Guardado con éxito');
    }

    public function show(Grupo $grupoarea)
    {
        abort_if(Gate::denies('configuracion_grupoarea_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $grupoarea->load('team');

        return view('admin.grupoarea.show', compact('grupoarea'));
    }

    public function edit(Grupo $grupoarea)
    {
        abort_if(Gate::denies('configuracion_grupoarea_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $grupoarea->load('team');

        return view('admin.grupoarea.edit', compact('grupoarea'));
    }

    public function update(Request $request, Grupo $grupoarea)
    {
        $request->validate(
            [
                'nombre' => 'required|string',
                'descripcion' => 'required|string'
            ],
        );
        $grupoarea->update($request->all());
        // Flash::success('<h5 class="text-center">Grupo actualizado satisfactoriamente</h5>');
        return redirect()->route('admin.grupoarea.index')->with("success", 'Editado con éxito');
    }

    public function destroy(Grupo $grupoarea)
    {
        abort_if(Gate::denies('configuracion_grupoarea_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $deleted = $grupoarea->delete();
        if ($deleted) {
            return response()->json(['deleted' => true]);
        } else {
            return response()->json(['deleted' => false]);
        }
    }

    public function massDestroy(MassDestroyGrupoAreaRequest $request)
    {
        Grupo::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function getRelationatedAreas(Request $request)
    {
        $grupo = Grupo::select('id')->where('id', intval($request->grupo_id))->first();
        $areas = Area::select('area')->where('id_grupo', $grupo->id)->get();
        return $areas;
    }
}
