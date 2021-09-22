<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Models\Area;
use App\Models\Sede;
use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\EducacionEmpleados;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\ExperienciaEmpleados;
use Intervention\Image\Facades\Image;
use App\Models\CursosDiplomasEmpleados;
use Illuminate\Support\Facades\Storage;
use App\Models\CertificacionesEmpleados;
use Yajra\DataTables\Facades\DataTables;
use App\Models\EvidenciasDocumentosEmpleados;
use Symfony\Component\HttpFoundation\Response;
use App\Models\EvidenciasCertificadosEmpleados;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {


        abort_if(Gate::denies('configuracion_empleados_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if ($request->ajax()) {
            // $query = DB::table('empleados')->select(DB::raw('id,
            // name,
            // foto,
            // area,
            // puesto,
            // jefe,
            // antiguedad as "fecha ingreso",
            // if(estatus = 1, "Activo", "Inactivo") as "estado",
            // concat(timestampdiff(year, antiguedad, NOW()), " año con ",
            // FLOOR(( datediff(now(), antiguedad) / 365.25 - FLOOR(datediff(now(), antiguedad) / 365.25)) * 12), " meses y ",
            // DAY(CURDATE()) - DAY(antiguedad) +30 * (DAY(CURDATE()) < DAY(antiguedad)) , " días."
            // ) as antiguedad,
            // email,
            // telefono,
            // n_empleado,
            // estatus,
            // n_registro
            // '))->whereNull('deleted_at')->get();
            $query = Empleado::get();
            $table = DataTables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');
            $table->addIndexColumn();

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'configuracion_empleados_show';
                $editGate      = 'configuracion_empleados_edit';
                $deleteGate    = 'configuracion_empleados_delete';
                $crudRoutePart = 'empleados';

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
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : "";
            });

            $table->editColumn('foto', function ($row) {
                return $row->foto ? $row->foto : '';
            });

            $table->editColumn('area', function ($row) {
                return $row->area ? $row->area->area : "";
            });
            $table->editColumn('puesto', function ($row) {
                return $row->puesto ? $row->puesto : "";
            });
            $table->editColumn(
                'jefe',
                function ($row) {
                    return $row->supervisor ? $row->supervisor->name : "";
                }
            );
            $table->editColumn('antiguedad', function ($row) {
                return Carbon::parse(Carbon::parse($row->antiguedad))->diffForHumans(Carbon::now()->subDays());
            });
            $table->editColumn('estatus', function ($row) {
                return $row->estatus ? $row->estatus : "";
            });
            $table->editColumn('email', function ($row) {
                return $row->email ? $row->email : "";
            });

            $table->editColumn('telefono', function ($row) {
                return $row->telefono ? $row->telefono : "";
            });

            $table->editColumn('n_empleado', function ($row) {
                return $row->n_empleado ? $row->n_empleado : "";
            });

            $table->editColumn('n_registro', function ($row) {
                return $row->n_registro ? $row->n_registro : "";
            });

            $table->editColumn('sede', function ($row) {
                return $row->sede ? $row->sede->sede : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        $ceo_exists = Empleado::select('supervisor_id')->whereNull('supervisor_id')->exists();
        return view('admin.empleados.index', compact('ceo_exists'));
    }



     public function getCertificaciones($empleado)
     {
        $certificaciones = CertificacionesEmpleados::where("empleado_id",intval($empleado))->get();
        return datatables()->of($certificaciones)->toJson();
     }

     public function getEducacion($empleado)
     {
        $educacions = EducacionEmpleados::where("empleado_id",intval($empleado))->get();
        return datatables()->of($educacions)->toJson();
     }

     public function getExperiencia($empleado)
     {
        $experiencias = ExperienciaEmpleados::where("empleado_id",intval($empleado))->get();
        return datatables()->of($experiencias)->toJson();
     }

     public function getCursos($empleado)
     {
        $cursos = CursosDiplomasEmpleados::where("empleado_id",intval($empleado))->get();
        return datatables()->of($cursos)->toJson();
     }

    public function create()
    {

        abort_if(Gate::denies('configuracion_empleados_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $empleados = Empleado::get();
        $ceo_exists = Empleado::select('supervisor_id')->whereNull('supervisor_id')->exists();
        $areas = Area::get();
        $sedes = Sede::get();
        $experiencias = ExperienciaEmpleados::get();
        $educacions = EducacionEmpleados::get();
        $cursos = CursosDiplomasEmpleados::get();
        $documentos = EvidenciasDocumentosEmpleados::get();
        $certificaciones = CertificacionesEmpleados::get();
        return view('admin.empleados.create', compact('empleados', 'ceo_exists', 'areas', 'sedes', 'experiencias', 'educacions', 'cursos', 'documentos', 'certificaciones'));
    }
    public function onlyStore($request)
    {

        // $experiencias = json_decode($request->experiencia);
        // $educacions = json_decode($request->educacion);
        // $cursos = json_decode($request->curso);
        // $certificados = json_decode($request->certificado);
        // dd($cursos);


        $ceo_exists = Empleado::select('supervisor_id')->whereNull('supervisor_id')->exists();
        $validateSupervisor = 'nullable|exists:empleados,id';
        if ($ceo_exists) {
            $validateSupervisor = 'required|exists:empleados,id';
        }

        $request->validate([
            'name' => 'required|string',
            'n_empleado' => 'required|unique:empleados',
            'area_id' => 'required|exists:areas,id',
            'supervisor_id' => $validateSupervisor,
            'puesto' => 'required|string',
            'antiguedad' => 'required',
            'estatus' => 'required',
            'email' => 'required|email',
            'sede_id' => 'required|exists:sedes,id',

        ], [
            'n_empleado.unique' => 'El número de empleado ya ha sido tomado'
        ]);

        $empleado = Empleado::create([
            "name" => $request->name,
            "area_id" =>  $request->area_id,
            "puesto" =>  $request->puesto,
            "supervisor_id" =>  $request->supervisor_id,
            "antiguedad" =>  $request->antiguedad,
            "estatus" =>  $request->estatus,
            "email" =>  $request->email,
            "telefono" =>  $request->telefono,
            "genero" =>  $request->genero,
            "n_empleado" =>  $request->n_empleado,
            "n_registro" =>  $request->n_registro,
            "sede_id" =>  $request->sede_id,
            "resumen" =>  $request->resumen,
            "cumpleaños" => $request->cumpleaños,
            "direccion" => $request->direccion,
            "telefono_movil" => $request->telefono_movil,
            "extension" => $request->extension,
        ]);
        $image = null;
        if ($request->snap_foto && $request->file('foto')) {
            if ($request->snap_foto) {
                if (preg_match('/^data:image\/(\w+);base64,/', $request->snap_foto)) {
                    $value = substr($request->snap_foto, strpos($request->snap_foto, ',') + 1);
                    $value = base64_decode($value);

                    $new_name_image = 'UID_' . $empleado->id . '_' . $empleado->name . '.png';
                    $image = $new_name_image;
                    $route = storage_path() . '/app/public/empleados/imagenes/' . $new_name_image;
                    $img_intervention = Image::make($request->snap_foto);
                    $img_intervention->resize(480, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($route);
                }
            }
        } else if ($request->snap_foto && !$request->file('foto')) {
            if ($request->snap_foto) {
                if (preg_match('/^data:image\/(\w+);base64,/', $request->snap_foto)) {
                    $value = substr($request->snap_foto, strpos($request->snap_foto, ',') + 1);
                    $value = base64_decode($value);

                    $new_name_image = 'UID_' . $empleado->id . '_' . $empleado->name . '.png';
                    $image = $new_name_image;
                    $route = storage_path() . '/app/public/empleados/imagenes/' . $new_name_image;
                    $img_intervention = Image::make($request->snap_foto);
                    $img_intervention->resize(480, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($route);
                }
            }
        } else {
            if ($request->file('foto') != null or !empty($request->file('foto'))) {
                $extension = pathinfo($request->file('foto')->getClientOriginalName(), PATHINFO_EXTENSION);
                $name_image = basename(pathinfo($request->file('foto')->getClientOriginalName(), PATHINFO_BASENAME), "." . $extension);
                $new_name_image = 'UID_' . $empleado->id . '_' . $empleado->name . '.' . $extension;
                $route = storage_path() . '/app/public/empleados/imagenes/' . $new_name_image;
                $image = $new_name_image;
                //Usamos image_intervention para disminuir el peso de la imagen
                $img_intervention = Image::make($request->file('foto'));
                $img_intervention->resize(480, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($route);
            }
        }

        $empleado->update([
            'foto' => $image
        ]);

        return $empleado;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $empleado = $this->onlyStore($request);

        return redirect()->route('admin.empleados.index')->with("success", 'Guardado con éxito');
    }

    public function storeWithCompetencia(Request $request)
    {

        $empleado = $this->onlyStore($request);

        return redirect()->route('admin.empleados.edit', $empleado)->with("success", 'Guardado con éxito');

        if ($request->hasFile('files')) {
            $files = $request->file('files');
            foreach ($files as $file) {
                if (Storage::putFileAs('public/documentos_empleados', $file, $file->getClientOriginalName())) {
                    EvidenciasDocumentosEmpleados::create([
                        'documentos' => $file->getClientOriginalName(),
                        'empleado_id' => $empleado->id,
                    ]);
                }
            }
        }
        // dd($request->hasFile('files'));

    }
    public function storeResumen(Request $request, $empleado)
    {
        $request->validate([
            "resumen" => "required|string|max:800"
        ]);
        if ($request->ajax()) {
            $empleado = Empleado::find(intval($empleado));
            $empleado->update([
                "resumen" => $request->resumen
            ]);
            if ($empleado) {
                return response()->json(['success' => true]);
            } else {
                return response()->json(['error' => true]);
            }
        }
    }

    public function storeCertificaciones(Request $request, $empleado)
    {
        $request->validate([
            "nombre" => "required|string|max:255",
            "estatus" => "required|string|max:255",
            "vigencia" => "required|date",
            "empleado_id" => "required|exists:empleados,id"
        ]);
        // dd($request->all());
        if ($request->ajax()) {
            $empleado = Empleado::find(intval($empleado));
            $certificado = CertificacionesEmpleados::create([
                'empleado_id' => $empleado->id,
                'nombre' => $request->nombre,
                'estatus' =>  $request->estatus,
                'vigencia' =>  $request->vigencia,
            ]);
            if ($request->hasFile('documento')) {
                $filenameWithExt = $request->file('documento')->getClientOriginalName();
                //Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                // Get just ext
                $extension = $request->file('documento')->getClientOriginalExtension();
                // Filename to store
                $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                // Upload Image
                $path = $request->file('documento')->storeAs('public/certificados_empleados', $fileNameToStore);

                $certificado->update([
                    "documento" => $fileNameToStore
                ]);
            }
            if ($empleado) {
                return response()->json(['success' => true]);
            } else {
                return response()->json(['error' => true]);
            }
        }
    }

    public function storeCursos(Request $request, $empleado)
    {
        $request->validate([
            "curso_diploma" => "required|string|max:255",
            "tipo" => "required",
            "año" => "required|date",
            "duracion" => "required",
            "empleado_id" => "required|exists:empleados,id"
        ]);
        // dd($request->all());
        if ($request->ajax()) {
            $empleado = Empleado::find(intval($empleado));
            $curso = CursosDiplomasEmpleados::create([
                'empleado_id' => $empleado->id,
                'curso_diploma' => $request->curso_diploma,
                'tipo' =>  $request->tipo,
                'año' =>  $request->año,
                'duracion' =>  $request->duracion,
            ]);

            if ($curso) {
                return response()->json(['success' => true]);
            } else {
                return response()->json(['error' => true]);
            }

        }
    }

    public function storeExperiencia(Request $request, $empleado)
    {

        $request->validate([
            "empresa" => "required|string|max:255",
            "puesto" => "required|string|max:255",
            "inicio_mes" => "required|date",
            "fin_mes" => "required|date",
            "descripcion"=>"required",
            "empleado_id" => "required|exists:empleados,id"

        ]);
        // dd($request->all());
        if ($request->ajax()) {
            $empleado = Empleado::find(intval($empleado));
            $experiencia = ExperienciaEmpleados::create([
                'empleado_id' => $empleado->id,
                'empresa' => $request->empresa,
                'puesto' =>  $request->puesto,
                'inicio_mes' =>  $request->inicio_mes,
                'fin_mes' =>  $request->fin_mes,
                'descripcion' =>  $request->descripcion,
            ]);
            if ($experiencia) {
                return response()->json(['success' => true]);
            } else {
                return response()->json(['error' => true]);
            }
        }
    }

    public function storeEducacion(Request $request, $empleado)
    {

        $request->validate([
            "institucion" => "required|string|max:255",
            "nivel" => "required",
            "año_inicio" => "required|date",
            "año_fin"=>"required|date",
            "empleado_id" => "required|exists:empleados,id"

        ]);
        // dd($request->all());
        if ($request->ajax()) {
            $empleado = Empleado::find(intval($empleado));
            $educacion = EducacionEmpleados::create([
                'empleado_id' => $empleado->id,
                'institucion' => $request->institucion,
                'nivel' =>  $request->nivel,
                'año_inicio' =>  $request->año_inicio,
                'año_fin' =>  $request->año_fin,
            ]);

            if ($educacion) {
                return response()->json(['success' => true]);
            } else {
                return response()->json(['error' => true]);
            }
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        abort_if(Gate::denies('configuracion_empleados_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $empleado = Empleado::findOrfail($id);
        // dd($empleado);
        $empleados = Empleado::get();
        $ceo_exists = Empleado::select('supervisor_id')->whereNull('supervisor_id')->exists();
        $areas = Area::get();
        $area = Area::findOrfail($empleado->area_id);
        $sedes = Sede::get();
        $sede = Sede::findOrfail($empleado->sede_id);
        $experiencias = ExperienciaEmpleados::get();
        $educacions = EducacionEmpleados::get();
        $cursos = CursosDiplomasEmpleados::get();
        $documentos = EvidenciasDocumentosEmpleados::get();
        return view('admin.empleados.edit', compact('empleado', 'empleados', 'ceo_exists', 'areas', 'area', 'sede', 'sedes', 'experiencias', 'educacions', 'cursos', 'documentos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $ceo = Empleado::select('id')->whereNull('supervisor_id')->first();
        $ceo_exists = Empleado::select('supervisor_id')->whereNull('supervisor_id')->exists();
        $validateSupervisor = 'nullable|exists:empleados,id';

        if ($ceo_exists) {
            if ($ceo->id == intval($id)) {
                $validateSupervisor = 'nullable|exists:empleados,id';
            } else {
                $validateSupervisor = 'required|exists:empleados,id';
            }
        }



        $request->validate([
            'name' => 'required|string',
            'n_empleado' => 'unique:empleados,n_empleado,' . $id,
            'area_id' => 'required|exists:areas,id',
            'supervisor_id' => $validateSupervisor,
            'puesto' => 'required|string',
            'antiguedad' => 'required',
            'estatus' => 'required',
            'email' => 'required|email',
            'sede_id' => 'required|exists:sedes,id',

        ], [
            'n_empleado.unique' => 'El número de empleado ya ha sido tomado'
        ]);



        $empleado = Empleado::find($id);
        $image = $empleado->foto;
        if ($request->snap_foto && $request->file('foto')) {
            if ($request->snap_foto) {
                if (preg_match('/^data:image\/(\w+);base64,/', $request->snap_foto)) {
                    $value = substr($request->snap_foto, strpos($request->snap_foto, ',') + 1);
                    $value = base64_decode($value);

                    $new_name_image = 'UID_' . $empleado->id . '_' . $empleado->name . '.png';
                    $image = $new_name_image;
                    $route = storage_path() . '/app/public/empleados/imagenes/' . $new_name_image;
                    $img_intervention = Image::make($request->snap_foto);
                    $img_intervention->resize(480, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($route);
                }
            }
        } else if (
            $request->snap_foto && !$request->file('foto')
        ) {
            if ($request->snap_foto) {
                if (preg_match('/^data:image\/(\w+);base64,/', $request->snap_foto)) {
                    $value = substr($request->snap_foto, strpos($request->snap_foto, ',') + 1);
                    $value = base64_decode($value);

                    $new_name_image = 'UID_' . $empleado->id . '_' . $empleado->name . '.png';
                    $image = $new_name_image;
                    $route = storage_path() . '/app/public/empleados/imagenes/' . $new_name_image;
                    $img_intervention = Image::make($request->snap_foto);
                    $img_intervention->resize(480, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($route);
                }
            }
        } else {
            if (
                $request->file('foto') != null or !empty($request->file('foto'))
            ) {
                $extension = pathinfo($request->file('foto')->getClientOriginalName(), PATHINFO_EXTENSION);
                $name_image = basename(pathinfo($request->file('foto')->getClientOriginalName(), PATHINFO_BASENAME), "." . $extension);
                $new_name_image = 'UID_' . $empleado->id . '_' . $request->name . '.' . $extension;
                $route = storage_path() . '/app/public/empleados/imagenes/' . $new_name_image;
                $image = $new_name_image;
                //Usamos image_intervention para disminuir el peso de la imagen
                $img_intervention = Image::make($request->file('foto'));
                $img_intervention->resize(480, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($route);
            }
        }

        if ($request->hasFile('files')) {
            $files = $request->file('files');
            foreach ($files as $file) {
                if (Storage::putFileAs('public/documentos_empleados', $file, $file->getClientOriginalName())) {
                    EvidenciasDocumentosEmpleados::create([
                        'documentos' => $file->getClientOriginalName(),
                        'empleado_id' => $empleado->id,
                    ]);
                }
            }
        }

        $empleado->update([

            'name' => $request->name,
            "area_id" =>  $request->area_id,
            "puesto" =>  $request->puesto,
            "supervisor_id" =>  $request->supervisor_id,
            "antiguedad" =>  $request->antiguedad,
            "estatus" =>  $request->estatus,
            "email" =>  $request->email,
            "telefono" =>  $request->telefono,
            "genero" =>  $request->genero,
            "n_empleado" =>  $request->n_empleado,
            "n_registro" =>  $request->n_empleado,
            'foto' => $image,
            "sede_id" => $request->sede_id,
            "cumpleaños" => $request->cumpleaños,
            "direccion" => $request->direccion,
            "telefono_movil" => $request->telefono_movil,
            "extension" => $request->extension,
        ]);

        // $gantt_path = 'storage/gantt/gantt_inicial.json';
        // $path = public_path($gantt_path);

        // $json_code = json_decode(file_get_contents($path), true);
        // $json_code['resources'] = Empleado::select('id', 'name', 'foto', 'genero')->get()->toArray();
        // $write_empleados = $json_code;
        // file_put_contents($path, json_encode($write_empleados));

        return redirect()->route('admin.empleados.index')->with("success", 'Editado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Empleado $empleado)
    {
        abort_if(Gate::denies('configuracion_empleados_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $empleado->delete();
        return back()->with('deleted', 'Registro eliminado con éxito');
    }

    public function deleteCertificaciones(Request $request, $certificacion)
    {
        if($request->ajax()){
            $certificacion=CertificacionesEmpleados::find(intval($certificacion));
            $u_certificacion=$certificacion->delete();
            if($u_certificacion){
                return response()->json(['success'=>true]);

            }
            else{
                return response()->json(['error'=>true]);
            }
        }
    }

    public function deleteCursos(Request $request, $curso)
    {
        if($request->ajax()){
            $curso=CursosDiplomasEmpleados::find(intval($curso));
            $u_curso=$curso->delete();
            if($u_curso){
                return response()->json(['success'=>true]);

            }
            else{
                return response()->json(['error'=>true]);
            }
        }
    }

    public function deleteEducacion(Request $request, $educacion)
    {
        if($request->ajax()){
            $educacion=EducacionEmpleados::find(intval($educacion));
            $u_educacion=$educacion->delete();
            if($u_educacion){
                return response()->json(['success'=>true]);

            }
            else{
                return response()->json(['error'=>true]);
            }
        }
    }

    public function deleteExperiencia(Request $request, $experiencia)
    {
        if($request->ajax()){
            $experiencia=ExperienciaEmpleados::find(intval($experiencia));
            $u_experiencia=$experiencia->delete();
            if($u_experiencia){
                return response()->json(['success'=>true]);

            }
            else{
                return response()->json(['error'=>true]);
            }
        }
    }

    public function getEmpleados(Request $request)
    {
        if ($request->ajax()) {
            $nombre = $request->nombre;
            if ($nombre != null) {
                $usuarios = Empleado::with('area')->where('name', 'ILIKE', '%' . $nombre . '%')->take(5)->get();
                $lista = "<ul class='list-group' id='empleados-lista'>";
                foreach ($usuarios as $usuario) {
                    $lista .= "<button type='button' class='px-2 py-1 text-muted list-group-item list-group-item-action' onClick='seleccionarUsuario(" . $usuario . ");'><i class='mr-2 fas fa-user-circle'></i>" . $usuario->name . "</button>";
                }
                $lista .= "</ul>";
                return $lista;
            }
        }
    }

    public function getEmpleadosLista(Request $request)
    {
        if ($request->ajax()) {
            $nombre = $request->nombre;
            if ($nombre != null) {
                $lista = Empleado::with('area')->where('name', 'ILIKE', '%' . $nombre . '%')->take(5)->get();
                $empleados = json_encode($lista);
                return $empleados;
            }
        }
    }
}
