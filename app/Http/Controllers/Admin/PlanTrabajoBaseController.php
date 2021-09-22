<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use App\Models\Empleado;
use Illuminate\Http\Request;
use App\Functions\Porcentaje;
use App\Models\ActividadFase;
use Illuminate\Http\Response;
use App\Models\PlanImplementacion;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Models\PlanImplementacionTask;
use Illuminate\Support\Facades\Storage;

class PlanTrabajoBaseController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('implementacion_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $gantt_path = 'storage/gantt/';
        $path = public_path($gantt_path);
        $json_code = json_decode(file_get_contents($path . '/gantt_inicial.json'), true);
        $json_code['resources'] = Empleado::select('id', 'name', 'foto', 'genero')->get()->toArray();
        $write_empleados = $json_code;
        file_put_contents($path . '/gantt_inicial.json', json_encode($write_empleados));


        $files = glob("storage/gantt/versiones/gantt_inicial*.json");
        $archivos_gantt = [];

        sort($files, SORT_NATURAL | SORT_FLAG_CASE);
        foreach ($files as $clave => $valor) {
            array_push($archivos_gantt, $valor);
        }

        $path_asset = asset('storage/gantt/versiones/');
        $gant_readed = end($archivos_gantt);
        $file_gant = json_decode(file_get_contents($gant_readed), true);
        $empleados = Empleado::select("name")->get();
        $name_file_gantt = 'gantt_inicial.json';


        return view('admin.planTrabajoBase.index', compact('archivos_gantt', 'path_asset', 'gant_readed', 'empleados', 'file_gant', 'name_file_gantt'));
    }



    public function saveImplementationProyect(Request $request)
    {
        $project =  $request->prj;
        $project = (array)json_decode($project);

        if (PlanImplementacion::find(1)) {
            $tasks = isset($project['tasks']) ? $project['tasks'] : [];
            PlanImplementacion::find(1)->update([
                'tasks' => $tasks,
                'canAdd' => isset($project['canAdd']) ? $project['canAdd'] : true,
                'canWrite' => isset($project['canWrite']) ? $project['canWrite'] : true,
                'canWriteOnParent' => isset($project['canWriteOnParent']) ? $project['canWriteOnParent'] : null,
                'changesReasonWhy' => isset($project['changesReasonWhy']) ? $project['changesReasonWhy'] : null,
                'selectedRow' => isset($project['selectedRow']) ? $project['selectedRow'] : 0,
                'zoom' => isset($project['zoom']) ? $project['zoom'] : '1M',
            ]);
        } else {
            $tasks = isset($project['tasks']) ? $project['tasks'] : [];
            PlanImplementacion::create([
                'tasks' => $tasks,
                'canAdd' => isset($project['canAdd']) ? $project['canAdd'] : true,
                'canWrite' => isset($project['canWrite']) ? $project['canWrite'] : true,
                'canWriteOnParent' => isset($project['canWriteOnParent']) ? $project['canWriteOnParent'] : null,
                'changesReasonWhy' => isset($project['changesReasonWhy']) ? $project['changesReasonWhy'] : null,
                'selectedRow' => isset($project['selectedRow']) ? $project['selectedRow'] : 0,
                'zoom' => isset($project['zoom']) ? $project['zoom'] : '1M',
            ]);
        }
        return response()->json(['success' => true], 200);
    }



    public function loadProyect()
    {
        $implementacion = PlanImplementacion::find(1);
        $tasks = $implementacion->tasks;
        foreach ($tasks as $task) {
            $task->end = intval($task->end);
            $task->start = intval($task->start);
            $task->canAdd = $task->canAdd == 'true' ? true : false;
            $task->canWrite = $task->canWrite == 'true' ? true : false;
            $task->duration = intval($task->duration);
            $task->progress = intval($task->progress);
            $task->canDelete = $task->canDelete == 'true' ? true : false;
            isset($task->level) ? $task->level = intval($task->level) : $task->level = 0;
            isset($task->collapsed) ? $task->collapsed = $task->collapsed == 'true' ? true : false : $task->collapsed = false;
            if (isset($task->canAddIssue)) {
                $task->canAddIssue = $task->canAddIssue == 'true' ? true : false;
            }
            if (isset($task->endIsMilestone)) {
                $task->endIsMilestone = $task->endIsMilestone == 'true' ? true : false;
            }
            if (isset($task->startIsMilestone)) {
                $task->startIsMilestone = $task->startIsMilestone == 'true' ? true : false;
            }
            if (isset($task->progressByWorklog)) {
                $task->progressByWorklog = $task->progressByWorklog == 'true' ? true : false;
            }
        }
        $implementacion->tasks = $tasks;

        return $implementacion;
    }



    public function saveCurrentProyect(Request $request)
    {
        if ($request->ajax()) {
            $gantt_path = 'storage/gantt/gantt_inicial.json';
            $path = public_path($gantt_path);
            $store = file_put_contents($path, $request->gantt);
            return response('guardado con exito', 200);
        }
    }

    public function saveStatus(Request $request)
    {
        if ($request->ajax()) {
            $status_path = 'storage/gantt/status.json';
            $path = public_path($status_path);
            file_put_contents($path, $request->estatuses);

            return response('guardado con exito', 200);
        }
    }

    public function checkChanges(Request $request)
    {
        if ($request->ajax()) {
            $proyecto = $request->txt_prj;
            Storage::disk('public')->put('gantt/tmp/ganttTemporal.json', $proyecto);
            $gantt_path = 'storage/gantt/';
            $path = public_path($gantt_path);
            $files = glob($path . "gantt_inicial*.json");
            $archivos_gantt = [];

            sort($files, SORT_NATURAL | SORT_FLAG_CASE);
            foreach ($files as $valor) {
                array_push($archivos_gantt, $valor);
            }

            $current_gantt = $path . "gantt_inicial.json";
            $tmp_gantt = json_decode(file_get_contents($path . 'tmp/ganttTemporal.json'));
            $old_gant = json_decode(file_get_contents($current_gantt));
            $notExistsChanges = $tmp_gantt == $old_gant;

            if (!$notExistsChanges) {
                return response()->json(['existsChanges' => true]);
            } else {
                return response()->json(['notExistsChanges' => true]);
            }
        }
    }
}
