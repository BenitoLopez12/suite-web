<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyPuestoRequest;
use App\Http\Requests\StorePuestoRequest;
use App\Http\Requests\UpdatePuestoRequest;
use App\Models\Area;
use App\Models\Empleado;
use App\Models\HerramientasPuestos;
use App\Models\Language;
use App\Models\Puesto;
use App\Models\PuestoContactos;
use App\Models\PuestoIdiomaPorcentajePivot;
use App\Models\PuestoResponsabilidade;
use App\Models\PuestosCertificado;
use App\Models\RH\Competencia;
use App\Models\Team;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class PuestosController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('puesto_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Puesto::with(['team'])->select(sprintf('%s.*', (new Puesto)->table))->orderByDesc('id');
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'puesto_show';
                $editGate = 'puesto_edit';
                $deleteGate = 'puesto_delete';
                $crudRoutePart = 'puestos';

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
            $table->editColumn('puesto', function ($row) {
                return $row->puesto ? $row->puesto : '';
            });
            $table->editColumn('descripcion', function ($row) {
                return $row->descripcion ? html_entity_decode(strip_tags($row->descripcion), ENT_QUOTES, 'UTF-8') : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        $teams = Team::get();

        return view('admin.puestos.index', compact('teams'));
    }

    public function create()
    {
        abort_if(Gate::denies('puesto_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $json = '[{
                    "abr":"zh",
                    "idioma":"Chinese"
                },
                {
                    "abr":"en",
                    "idioma":"English"
                },
                {
                    "abr":"fr",
                    "idioma":"French"
                },
                {
                    "abr":"id",
                    "idioma":"Indonesian"
                },
                {
                    "abr":"it",
                    "idioma":"Italian"
                },
                {
                    "abr":"ja",
                    "idioma":"Japanese"
                },
                {
                    "abr":"pt",
                    "idioma":"Portuguese"
                },
                {
                    "abr":"es",
                    "idioma":"Spanish; Castilian"
                }]
        ';

        $lenguajes = (json_decode($json));

        // dd($lenguajes);

        /*
        $lenguajes = [
            1=>{
                "abr" => "zh",
                "idioma"=>"Chinese",
            },
            2=>[
                "abr" => "en",
                "idioma"=>"English",
            ],
            3=>[
                "abr" => "fr",
                "idioma"=>"French",

            ],
            4=>[
                "abr" => "id",
                "idioma"=>"Indonesian",
            ],
            5=>[
                "abr" => "it",
                "idioma"=>"Italian",
            ],
            6=>[
                "abr" => "ja",
                "idioma"=>"Japanese",
            ],
            7=>[
                "abr" => "pt",
                "idioma"=>"Portuguese",
            ],

            8=>[
                "abr" => "es",
                "idioma"=>"Spanish; Castilian",
            ],
        ];
        */
        // dd($lenguajes);
        $areas = Area::get();
        $reportas = Empleado::get();
        $idis = Language::all();
        $competencias = Competencia::all();
        $responsabilidades = PuestoResponsabilidade::get();
        $certificados = PuestosCertificado::get();
        $puestos = Puesto::get();
        $herramientas = HerramientasPuestos::get();
        $contactos = PuestoContactos::get();
        $puesto = Puesto::get();
        $empleados= Empleado::get();
        // $perfiles_seleccionado = $puesto->perfil_empleado_id;
        // dd($idis);

        return view('admin.puestos.create', compact('areas', 'reportas', 'lenguajes', 'idis', 'competencias', 'responsabilidades', 'certificados', 'puesto', 'herramientas', 'contactos', 'empleados'));
    }

    public function store(StorePuestoRequest $request)
    {
        // dd($request->all());
        $puesto = Puesto::create($request->all());

        // $this->saveOrUpdateLanguage($request->idiomas, $puesto);
        // $this->saveOrUpdateLanguage($request, $puesto);
        $this->saveUpdateResponsabilidades($request->responsabilidades, $puesto);
        $this->saveUpdateCertificados($request->certificados, $puesto);
        $this->saveUpdateHerramientas($request->herramientas, $puesto);
        $this->saveUpdateContactos($request->contactos, $puesto);
        $this->saveOrUpdateLanguage($request->id_language, $puesto);

        return redirect()->route('admin.puestos.index');
    }

    public function edit(Puesto $puesto)
    {
        abort_if(Gate::denies('puesto_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $json = '[{
                    "abr":"zh",
                    "idioma":"Chinese"
                },
                {
                    "abr":"en",
                    "idioma":"English"
                },
                {
                    "abr":"fr",
                    "idioma":"French"
                },
                {
                    "abr":"id",
                    "idioma":"Indonesian"
                },
                {
                    "abr":"it",
                    "idioma":"Italian"
                },
                {
                    "abr":"ja",
                    "idioma":"Japanese"
                },
                {
                    "abr":"pt",
                    "idioma":"Portuguese"
                },
                {
                    "abr":"es",
                    "idioma":"Spanish; Castilian"
                }]
        ';
        // $this->saveOrUpdateSchedule($request, $puesto);
        $lenguajes = (json_decode($json));
        $areas = Area::get();
        $reportas = Empleado::get();
        $puesto->load(['contactos'=>function ($query) {
            $query->with(['empleados'=>function ($query) {
                $query->with('puestoRelacionado');
            }]);
        }]);
        $competencias = Competencia::all();
        $idis = Language::all();
        $responsabilidades = PuestoResponsabilidade::get();
        // dd($puesto);
        $certificados = PuestosCertificado::get();
        $herramientas = HerramientasPuestos::get();
        $contactos = PuestoContactos::get();
        $empleados = Empleado::get();
        $language = PuestoIdiomaPorcentajePivot::get();
        // $perfiles_seleccionado = $puesto->perfil_empleado_id;


        return view('admin.puestos.edit', compact('puesto', 'areas', 'reportas', 'lenguajes', 'competencias', 'idis', 'responsabilidades', 'certificados', 'herramientas', 'contactos', 'empleados', 'language'));
    }

    public function update(UpdatePuestoRequest $request, Puesto $puesto)
    {
        // dd($request->all());
        $puesto->update($request->all());

        // $this->saveUpdateResponsabilidades($request->responsabilidades, $puesto);
        // $this->saveOrUpdateLanguage($request, $puesto);
        $this->saveUpdateResponsabilidades($request->responsabilidades, $puesto);

        $this->saveUpdateCertificados($request->certificados, $puesto);
        $this->saveUpdateHerramientas($request->herramientas, $puesto);
        $this->saveUpdateContactos($request->contactos, $puesto);
        $this->saveOrUpdateLanguage($request->id_language, $puesto);

        return redirect()->route('admin.puestos.index');
    }

    public function show(Puesto $puesto)
    {
        abort_if(Gate::denies('puesto_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $puesto->load('team');
        // $empleados = Empleado::with('area')->get();
        // $idiomas = PuestoIdiomaPorcentajePivot::get();
        $competencias = Competencia::get();
        $responsabilidades = PuestoResponsabilidade::get();
        $certificados = PuestosCertificado::get();
        $idiomas = PuestoIdiomaPorcentajePivot::where('id_puesto', '=', $puesto->id)->get();
        $herramientas = HerramientasPuestos::get();
        $contactos = PuestoContactos::get();
        $empleados = Empleado::get();
        $areas = Area::get();

        return view('admin.puestos.show', compact('puesto', 'idiomas', 'competencias', 'responsabilidades', 'certificados', 'idiomas', 'herramientas', 'contactos', 'empleados', 'areas'));
    }

    public function destroy(Puesto $puesto)
    {
        abort_if(Gate::denies('puesto_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $puesto->delete();

        return back();
    }

    public function massDestroy(MassDestroyPuestoRequest $request)
    {
        Puesto::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function consultaPuestos(Request $request)
    {
        // $areas = Area::get();

        return view('admin.puestos.consultapuestos');
    }

    // public function saveOrUpdateLanguage(Request $request, $puesto)
    // {
    //     $id = $puesto->id;
    //     // dd($id);
    //     $i = 0;
    //     if (isset($request->id_language)) {
    //         if (count($request->id_language)) {
    //             foreach ($request->id_language as $w) {
    //                 if (isset($w['id'])) {
    //                     $model = PuestoIdiomaPorcentajePivot::where('id', $w['id']);
    //                     $registerAlreadyExists = $model->exists();

    //                     if ($registerAlreadyExists) {
    //                         $dataModel = $model->first();

    //                         $dataModel->update([
    //                             'id_language'  => $w['language'],
    //                             'porcentaje' =>  $w['porcentaje'],
    //                             'nivel' =>  $w['nivel'],
    //                         ]);
    //                     }
    //                 } else {
    //                     PuestoIdiomaPorcentajePivot::create([

    //                         'id_language' => $w['language'],
    //                         'porcentaje' => $w['porcentaje'],
    //                         'nivel' => $w['nivel'],
    //                         'id_puesto' => $id,
    //                     ]);
    //                 }
    //             }
    //         }
    //     }
    // }

    public function saveOrUpdateLanguage($languajes, $puesto)
    {

        if (!is_null($languajes)) {
            foreach ($languajes as $languaje) {
                // dd($languaje);
                // dd(PuestoResponsabilidade::exists($languaje['id']));
                if (PuestoIdiomaPorcentajePivot::find($languaje['id']) != null) {
                    PuestoIdiomaPorcentajePivot::find($languaje['id'])->update([
                        'id_language'=>$languaje['language'],
                        'porcentaje' => $languaje['porcentaje'],
                        'nivel' =>  $languaje['nivel'],
                        'id_puesto' => $puesto->id,
                    ]);
                } else {
                    PuestoIdiomaPorcentajePivot::create([
                        'id_puesto' => $puesto->id,
                        'porcentaje' => $languaje['porcentaje'],
                        'nivel' =>  $languaje['nivel'],
                        'id_language'=>$languaje['language'],
                    ]);
                }
            }
        }


    }

    public function deleteLanguage(Request $request, $language)
    {
        $language = PuestoIdiomaPorcentajePivot::find($language);
        $language->delete();

        return response()->json(['status' => 'success', 'message' => 'Dato Eliminado']);
    }

    public function saveUpdateResponsabilidades($responsabilidades, $puesto)
    {
        if (!is_null($responsabilidades)) {
            foreach ($responsabilidades as $responsabilidad) {
                // dd($responsabilidad);
                // dd(PuestoResponsabilidade::exists($responsabilidad['id']));
                if (PuestoResponsabilidade::find($responsabilidad['id']) != null) {
                    PuestoResponsabilidade::find($responsabilidad['id'])->update([
                        'tiempo_asignado' => $responsabilidad['tiempo_asignado'],
                        'indicador' =>  $responsabilidad['indicador'],
                        'resultado' =>  $responsabilidad['resultado'],
                        'actividad' =>  $responsabilidad['actividad'],
                    ]);
                } else {
                    PuestoResponsabilidade::create([
                        'puesto_id' => $puesto->id,
                        'tiempo_asignado' => $responsabilidad['tiempo_asignado'],
                        'indicador' =>  $responsabilidad['indicador'],
                        'resultado' =>  $responsabilidad['resultado'],
                        'actividad' =>  $responsabilidad['actividad'],
                    ]);
                }
            }
        }
        // dd($responsabilidades);
    }

    public function deleteResponsabilidades(Request $request, $responsabilidades)
    {
        $responsabilidades = PuestoResponsabilidade::find($responsabilidades);
        $responsabilidades->delete();

        return response()->json(['status' => 'success', 'message' => 'Dato Eliminado']);
    }

    public function saveUpdateCertificados($certificados, $puesto)
    {
        if (!is_null($certificados)) {
            foreach ($certificados as $certificado) {
                // dd(PuestoResponsabilidade::exists($responsabilidad['id']));
                if (PuestosCertificado::find($certificado['id']) != null) {
                    PuestosCertificado::find($certificado['id'])->update([
                        'nombre' => $certificado['nombre'],
                        'requisito' =>  $certificado['requisito'],
                    ]);
                } else {
                    PuestosCertificado::create([
                        'puesto_id' => $puesto->id,
                        'nombre' => $certificado['nombre'],
                        'requisito' =>  $certificado['requisito'],
                    ]);
                }
            }
        }
        // dd($responsabilidades);
    }

    public function deleteCertificados(Request $request, $certificados)
    {
        $certificados = PuestosCertificado::find($certificados);
        $certificados->delete();

        return response()->json(['status' => 'success', 'message' => 'Dato Eliminado']);
    }

    public function saveUpdateHerramientas($herramientas, $puesto)
    {
        if (!is_null($herramientas)) {
            foreach ($herramientas as $herramienta) {
                // dd(PuestoResponsabilidade::exists($responsabilidad['id']));
                if (HerramientasPuestos::find($herramienta['id']) != null) {
                    HerramientasPuestos::find($herramienta['id'])->update([
                        'nombre_herramienta' => $herramienta['nombre_herramienta'],
                        'descripcion_herramienta' =>  $herramienta['descripcion_herramienta'],
                    ]);
                } else {
                    HerramientasPuestos::create([
                        'puesto_id' => $puesto->id,
                        'nombre_herramienta' => $herramienta['nombre_herramienta'],
                        'descripcion_herramienta' =>  $herramienta['descripcion_herramienta'],
                    ]);
                }
            }
        }
        // dd($responsabilidades);
    }

    public function deleteHerramientas(Request $request, $herramientas)
    {
        $herramientas = HerramientasPuestos::find($herramientas);
        $herramientas->delete();

        return response()->json(['status' => 'success', 'message' => 'Dato Eliminado']);
    }

    public function saveUpdateContactos($contactos, $puesto)
    {
        if (!is_null($contactos)) {
            foreach ($contactos as $contacto) {
                // dd(PuestoResponsabilidade::exists($responsabilidad['id']));
                if (PuestoContactos::find($contacto['id']) != null) {
                    PuestoContactos::find($contacto['id'])->update([
                        'id_contacto' => $contacto['id_contacto'],
                        'descripcion_contacto' =>  $contacto['descripcion_contacto'],
                    ]);
                } else {
                    PuestoContactos::create([
                        'puesto_id' => $puesto->id,
                        'id_contacto' => $contacto['id_contacto'],
                        'descripcion_contacto' =>  $contacto['descripcion_contacto'],
                    ]);
                }
            }
        }
        // dd($contactos);
    }

    public function deleteContactos(Request $request, $contactos)
    {
        $contactos = PuestoContactos::find($contactos);
        $contactos->delete();

        return response()->json(['status' => 'success', 'message' => 'Dato Eliminado']);
    }
}
