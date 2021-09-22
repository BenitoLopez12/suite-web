<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyMaterialSgsiRequest;
use App\Http\Requests\StoreMaterialSgsiRequest;
use App\Http\Requests\UpdateMaterialSgsiRequest;
use App\Models\Area;
use App\Models\MaterialSgsi;
use App\Models\Team;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use App\Models\DocumentoMaterialSgsi;

class MaterialSgsiController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        
        abort_if(Gate::denies('material_sgsi_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        // dd(MaterialSgsi::with('arearesponsable', 'team','documentos_material')->get());
        if ($request->ajax()) {
           
            $query = MaterialSgsi::with(['arearesponsable', 'team','documentos_material'])->select(sprintf('%s.*', (new MaterialSgsi)->table));
            $table = Datatables::of($query);
            

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'material_sgsi_show';
                $editGate      = 'material_sgsi_edit';
                $deleteGate    = 'material_sgsi_delete';
                $crudRoutePart = 'material-sgsis';

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
            $table->editColumn('objetivo', function ($row) {
                return $row->objetivo ? $row->objetivo : "";
            });
            $table->editColumn('personalobjetivo', function ($row) {
                return $row->personalobjetivo ? MaterialSgsi::PERSONALOBJETIVO_SELECT[$row->personalobjetivo] : '';
            });
            $table->addColumn('arearesponsable_area', function ($row) {
                return $row->arearesponsable ? $row->arearesponsable->area : '';
            });

            $table->editColumn('tipoimparticion', function ($row) {
                return $row->tipoimparticion ? MaterialSgsi::TIPOIMPARTICION_SELECT[$row->tipoimparticion] : '';
            });

            // $table->editColumn('archivo', function ($row) {
            //     return $row->archivo ? '<a href="' . $row->archivo->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            // });

            $table->editColumn('archivo', function ($row) {
                return $row->documentos_material ? $row->documentos_material:[];
            });

            $table->rawColumns(['actions', 'placeholder', 'arearesponsable', 'archivo']);

            return $table->make(true);

            
            // $materialSgsi = MaterialSgsi::with('team','documentos_material')->get();
            // return datatables()->of($materialSgsi)->toJson();
        }

        $areas = Area::get();
        $teams = Team::get();

        return view('admin.materialSgsis.index', compact('areas', 'teams'));
    }

    public function create()
    {
        abort_if(Gate::denies('material_sgsi_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $arearesponsables = Area::all()->pluck('area', 'id')->prepend(trans('global.pleaseSelect'), '');
        $documentos = DocumentoMaterialSgsi::get();

        return view('admin.materialSgsis.create', compact('arearesponsables', 'documentos'));

       
        
    }

    public function store(Request $request)
    {
        $materialSgsi = MaterialSgsi::create($request->all());
        if ($request->hasFile('files')) {
            $files = $request->file('files');
            foreach ($files as $file) {
                if (Storage::putFileAs('storage/documentos_material_sgsi', $file, $file->getClientOriginalName())) {
                    DocumentoMaterialSgsi::create([
                        'documento' => $file->getClientOriginalName(),
                        'material_id' => $materialSgsi->id,
                    ]);
                }
            }
        }
        // if ($request->input('archivo', false)) {
        //     $materialSgsi->addMedia(storage_path('tmp/uploads/' . $request->input('archivo')))->toMediaCollection('archivo');
        // }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $materialSgsi->id]);
        }

        return redirect()->route('admin.material-sgsis.index')->with("success", 'Guardado con éxito');
    }

    public function edit(MaterialSgsi $materialSgsi)
    {
        abort_if(Gate::denies('material_sgsi_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $arearesponsables = Area::all()->pluck('area', 'id')->prepend(trans('global.pleaseSelect'), '');
        $documentos=DocumentoMaterialSgsi::get();
        $materialSgsi->load('arearesponsable', 'team');

        return view('admin.materialSgsis.edit', compact('arearesponsables', 'materialSgsi', 'documentos'));
    }

    public function update(UpdateMaterialSgsiRequest $request, MaterialSgsi $materialSgsi)
    {
        $materialSgsi->update($request->all());
        $files = $request->file('files');
        if ($request->hasFile('files')) {
            foreach ($files as $file) {
                if (Storage::putFileAs('storage/documentos_material_sgsi', $file, $file->getClientOriginalName())) {
                    DocumentoMaterialSgsi::create([
                        'documento' => $file->getClientOriginalName(),
                        'material_id' => $materialSgsi->id,
                    ]);
                }
            }
        }

        return redirect()->route('admin.material-sgsis.index')->with("success", 'Editado con éxito');
    }

    public function show(MaterialSgsi $materialSgsi)
    {
        abort_if(Gate::denies('material_sgsi_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $materialSgsi->load('arearesponsable', 'team');

        return view('admin.materialSgsis.show', compact('materialSgsi'));
    }

    public function destroy(MaterialSgsi $materialSgsi)
    {
        abort_if(Gate::denies('material_sgsi_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $materialSgsi->delete();

        return back()->with('deleted', 'Registro eliminado con éxito');
    }

    public function massDestroy(MassDestroyMaterialSgsiRequest $request)
    {
        MaterialSgsi::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('material_sgsi_create') && Gate::denies('material_sgsi_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new MaterialSgsi();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
