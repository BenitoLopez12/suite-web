<?php

namespace App\Http\Controllers\Api\V1\AnalisisRiesgo;

use App\Http\Controllers\Controller;
use App\Http\Requests\AnalisisRiesgo\CreateSectionQuestionTemplateRequest;
use App\Models\TBDataQuestionTemplateAnalisisRiesgoModel;
use App\Models\TBQuestionTemplateAnalisisRiesgoModel;
use App\Models\TBQuestionTemplateAr_DataQuestionTemplateArModel;
use App\Models\TBSectionTemplateAnalisisRiesgoModel;
use App\Models\TBSectionTemplateAr_QuestionTemplateArModel;
use App\Models\TBTemplateAnalisisRiesgoModel;
use App\Models\Template_Analisis_Riesgos;
use App\Models\TBFormulaTemplateAnalisisRiesgoModel;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class templateAnalisisRiesgoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateSectionQuestionTemplateRequest $request)
    {
        $sections = $request->input('sections');
        $questions = $request->input('questions');
        $this->saveSections($sections, $questions);

        return json_encode(['data' => 'Se crearon exitosamente las secciones y las preguntas'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        try {
            $template = TBTemplateAnalisisRiesgoModel::findOrFail($id);

            $sections = TBSectionTemplateAnalisisRiesgoModel::select('id', 'title', 'template_id', 'position')
                ->where('template_id', $template->id)->get();

            $questions = [];

            foreach ($sections as $section) {
                $data = $section->questions;
                $sectionId = $section->id;

                $filter = $data->reject(function ($registro) {
                    if($registro['type'] === '11'){
                        return $registro;
                    }
                });

                $newQuestions = $filter->map(function ($itm) use ($sectionId) {
                    Arr::forget($itm, 'created_at');
                    Arr::forget($itm, 'updated_at');
                    Arr::forget($itm, 'pivot');
                    Arr::forget($itm, 'deleted_at');
                    $itm->columnId = $sectionId;
                    $this->getDataQuestion($itm);
                    return $itm;
                });

                Arr::forget($section, 'questions');

                foreach ($newQuestions as $newQuestion) {
                    array_push($questions, $newQuestion);
                }
            }

            return json_encode(['data' => ['sections' => $sections, 'questions' => $questions]], 200);

        } catch (\Throwable $th) {
            throw $th;

            return response()->json(['message' => 'No encontrado'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $requestSections = $request->input('sections');
        $requestQuestions = $request->input('questions');

        $dataFilter = $this->filterData($requestSections, $requestQuestions);
        $sections = $dataFilter['sections'];
        $newSections = $dataFilter['newSections'];
        $questions = $dataFilter['questions'];
        $newQuestions = $dataFilter['newQuestions'];

        $this->saveSections($newSections, $newQuestions);

        $this->updateSections($sections);
        $this->updateQuestions($questions);

        return json_encode(['data' => 'Se actualizaron exitosamente las secciones y las preguntas']);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Template_Analisis_Riesgos $template_Analisis_Riesgos)
    {
        //
    }

    public function saveSections($sections, $questions)
    {
        DB::beginTransaction();
        try {
            foreach ($sections as $section) {
                $sectionId = $section['id'];
                $questionsFilter = array_filter($questions, function ($item) use ($sectionId) {
                    return $item['columnId'] === $sectionId;
                });

                $sectionCreate = TBSectionTemplateAnalisisRiesgoModel::create([
                    'title' => $section['title'],
                    'template_id' => $section['template_id'],
                    'position' => $section['position'],
                ]);

                $sectionId = $sectionCreate->id;
                $this->saveQuestions($sectionId, $questionsFilter);
            }
            DB::commit();
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
        }
    }

    public function saveQuestions($sectionId, $questions)
    {

        foreach ($questions as $question) {
            $id = $question['id'];
            $exist = intval($id);
            if (! $exist) {
                DB::beginTransaction();
                try {
                    $questionCreate = TBQuestionTemplateAnalisisRiesgoModel::create([
                        'title' => $question['title'],
                        'size' => $question['size'],
                        'type' => $question['type'],
                        'position' => $question['position'],
                        'obligatory' => $question['obligatory'],
                    ]);

                    TBSectionTemplateAr_QuestionTemplateArModel::create([
                        'section_id' => $sectionId,
                        'question_id' => $questionCreate->id,
                    ]);
                    $this->filterSaveDataQuestion($question, $questionCreate);
                    DB::commit();
                } catch (\Throwable $th) {
                    DB::rollback();

                    continue;
                }
            } else {
                $pivot = TBSectionTemplateAr_QuestionTemplateArModel::where('question_id', $id)->first();
                $register = TBQuestionTemplateAnalisisRiesgoModel::where('id', $id)->first();
                DB::beginTransaction();
                try {
                    $register->update([
                        'title' => $question['title'],
                        'size' => $question['size'],
                        'type' => $question['type'],
                        'position' => $question['position'],
                        'obligatory' => $question['obligatory'],
                    ]);
                    $pivot->update(
                        ['section_id' => $sectionId],
                    );
                    DB::commit();
                } catch (\Throwable $th) {
                    DB::rollback();

                    continue;
                }
            }
        }

    }

    public function updateSections($sections)
    {
        foreach ($sections as $section) {
            $id = $section['id'];
            $sectionRegister = TBSectionTemplateAnalisisRiesgoModel::find($id);
            DB::beginTransaction();
            try {
                $sectionRegister->update([
                    'title' => $section['title'],
                    'position' => $section['position'],
                ]);
                DB::commit();
            } catch (\Throwable $th) {
                DB::rollback();

                continue;
            }
        }
    }

    public function updateQuestions($questions)
    {
        foreach ($questions as $question) {
            $id = $question['id'];
            $exist = intval($id);

            if ($exist) {
                // dd($question);
                $pivot = TBSectionTemplateAr_QuestionTemplateArModel::where('question_id', $id)->first();
                $register = TBQuestionTemplateAnalisisRiesgoModel::where('id', $id)->first();
                DB::beginTransaction();
                try {
                    $register->update([
                        'title' => $question['title'],
                        'size' => $question['size'],
                        'type' => $question['type'],
                        'position' => $question['position'],
                        'obligatory' => $question['obligatory'],
                    ]);
                    $pivot->update(
                        ['section_id' => $question['columnId']],
                    );

                    $this->filterUpdateDataQuestion($question, $id);
                    DB::commit();
                } catch (\Throwable $th) {
                    DB::rollback();
                    continue;
                }
            } else {

                DB::beginTransaction();
                try {
                    $questionCreate = TBQuestionTemplateAnalisisRiesgoModel::create([
                        'title' => $question['title'],
                        'size' => $question['size'],
                        'type' => $question['type'],
                        'position' => $question['position'],
                        'obligatory' => $question['obligatory'],
                    ]);

                    TBSectionTemplateAr_QuestionTemplateArModel::create([
                        'section_id' => $question['columnId'],
                        'question_id' => $questionCreate->id,
                    ]);

                    $this->filterSaveDataQuestion($question, $questionCreate);
                    DB::commit();
                } catch (\Throwable $th) {
                    //throw $th;
                    DB::rollback();

                    continue;
                }

            }
        }

    }

    public function filterData($requestSections, $requestQuestions)
    {
        $sections = [];
        $questions = [];
        $newSections = [];
        $newQuestions = [];

        foreach ($requestSections as $requestSection) {
            $id = intval($requestSection['id']);
            if ($id) {
                $sections[] = $requestSection;
            } else {

                $newSections[] = $requestSection;
            }
        }

        foreach ($requestQuestions as $requestQuestion) {
            $id = intval($requestQuestion['id']);
            $columnId = intval($requestQuestion['columnId']);

            if ($id && $columnId) {
                $questions[] = $requestQuestion;
            } elseif ($columnId) {
                $questions[] = $requestQuestion;

            } else {
                $newQuestions[] = $requestQuestion;
            }
        }

        return ['sections' => $sections, 'newSections' => $newSections, 'questions' => $questions, 'newQuestions' => $newQuestions];
    }

    public function filterSaveDataQuestion($question, $questionCreate)
    {
        switch ($question['type']) {
            case '3':
                $this->saveDataQuestionMinMax($question['data'], $questionCreate->id);
                break;
            case '5':
                $this->saveMultipleDataQuestion($question['data'], $questionCreate->id);
                break;
            case '6':
                $this->saveMultipleDataQuestion($question['data'], $questionCreate->id);
                break;
            case '7':
                $this->saveSelectDataQuestion($question['data'], $questionCreate->id);
                break;
            default:
                break;
        }
    }

    public function filterUpdateDataQuestion($question, $questionCreate)
    {
        switch ($question['type']) {
            case '3':
                $this->updateDataQuestionMinMax($question['data'], $questionCreate);
                break;
            case '5':
                $this->updateMultipleDataQuestion($question['data'], $questionCreate);
                break;
            case '6':
                $this->updateMultipleDataQuestion($question['data'], $questionCreate);
                break;
            case '7':
                $this->updateSelectDataQuestion($question['data'], $questionCreate);
                break;
            default:
                break;
        }
    }

    public function saveDataQuestionMinMax($dataQuestion, $questionCreateId)
    {
        DB::beginTransaction();
        try {
            $dataQuestionCreate = TBDataQuestionTemplateAnalisisRiesgoModel::create([
                'minimum' => intval($dataQuestion['minimo']),
                'maximum' => intval($dataQuestion['maximo']),
            ]);

            TBQuestionTemplateAr_DataQuestionTemplateArModel::create([
                'question_id' => $questionCreateId,
                'dataquestion_id' => $dataQuestionCreate->id,
            ]);

            DB::commit();
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
        }

    }

    public function updateDataQuestionMinMax($dataQuestion)
    {
        // dd($dataQuestion);
        DB::beginTransaction();
        $register = TBDataQuestionTemplateAnalisisRiesgoModel::find($dataQuestion['id']);

        try {
            $register->update([
                'minimum' => intval($dataQuestion['minimo']),
                'maximum' => intval($dataQuestion['maximo']),
            ]);

            DB::commit();
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
        }

    }

    public function saveMultipleDataQuestion($dataQuestions, $questionCreateId)
    {
        foreach ($dataQuestions as $dataQuestion) {
            DB::beginTransaction();
            try {
                $dataQuestionCreate = TBDataQuestionTemplateAnalisisRiesgoModel::create([
                    'title' => $dataQuestion['title'],
                    'name' => $dataQuestion['name'],
                    'status' => $dataQuestion['status'],
                ]);

                TBQuestionTemplateAr_DataQuestionTemplateArModel::create([
                    'question_id' => $questionCreateId,
                    'dataquestion_id' => $dataQuestionCreate->id,
                ]);

                DB::commit();
            } catch (\Throwable $th) {
                //throw $th;
                DB::rollback();

                continue;
            }
        }
    }

    public function updateMultipleDataQuestion($dataQuestions, $questionCreateId)
    {
        foreach ($dataQuestions as $dataQuestion) {
            $id = $dataQuestion['id'];
            if (is_int($id)) {
                DB::beginTransaction();
                $register = TBDataQuestionTemplateAnalisisRiesgoModel::find($id);
                try {
                    $register->update([
                        'title' => $dataQuestion['title'],
                        'name' => $dataQuestion['name'],
                        'status' => $dataQuestion['status'],
                    ]);
                    DB::commit();
                } catch (\Throwable $th) {
                    //throw $th;
                    DB::rollback();

                    continue;
                }
            } else {
                DB::beginTransaction();
                try {
                    $dataQuestionCreate = TBDataQuestionTemplateAnalisisRiesgoModel::create([
                        'title' => $dataQuestion['title'],
                        'name' => $dataQuestion['name'],
                        'status' => $dataQuestion['status'],
                    ]);

                    TBQuestionTemplateAr_DataQuestionTemplateArModel::create([
                        'question_id' => $questionCreateId,
                        'dataquestion_id' => $dataQuestionCreate->id,
                    ]);

                    DB::commit();
                } catch (\Throwable $th) {
                    // throw $th;
                    DB::rollback();

                    continue;
                }
            }
        }
    }

    public function saveSelectDataQuestion($dataQuestions, $questionCreateId)
    {
        foreach ($dataQuestions as $dataQuestion) {
            DB::beginTransaction();
            try {
                $dataQuestionCreate = TBDataQuestionTemplateAnalisisRiesgoModel::create([
                    'title' => $dataQuestion['title'],
                    'name' => $dataQuestion['name'],
                ]);

                TBQuestionTemplateAr_DataQuestionTemplateArModel::create([
                    'question_id' => $questionCreateId,
                    'dataquestion_id' => $dataQuestionCreate->id,
                ]);

                DB::commit();
            } catch (\Throwable $th) {
                //throw $th;
                DB::rollback();

                continue;
            }
        }
    }

    public function updateSelectDataQuestion($dataQuestions, $questionCreateId)
    {
        foreach ($dataQuestions as $dataQuestion) {
            $id = $dataQuestion['id'];
            if (is_int($id)) {
                DB::beginTransaction();
                $register = TBDataQuestionTemplateAnalisisRiesgoModel::find($dataQuestion['id']);
                try {
                    $register->update([
                        'title' => $dataQuestion['title'],
                        'name' => $dataQuestion['name'],
                    ]);

                    DB::commit();
                } catch (\Throwable $th) {
                    //throw $th;
                    DB::rollback();

                    continue;
                }
            } else {
                DB::beginTransaction();
                try {
                    $dataQuestionCreate = TBDataQuestionTemplateAnalisisRiesgoModel::create([
                        'title' => $dataQuestion['title'],
                        'name' => $dataQuestion['name'],
                    ]);

                    TBQuestionTemplateAr_DataQuestionTemplateArModel::create([
                        'question_id' => $questionCreateId,
                        'dataquestion_id' => $dataQuestionCreate->id,
                    ]);

                    DB::commit();
                } catch (\Throwable $th) {
                    //throw $th;
                    DB::rollback();

                    continue;
                }
            }
        }
    }

    public function getDataQuestion($question)
    {
        // dd($questionId);
        $register = TBQuestionTemplateAnalisisRiesgoModel::findOrFail($question->id);
        $data = $register->dataQuestions;
        switch ($question->type) {
            case '3':
                foreach ($data as $item) {
                    Arr::forget($item, 'created_at');
                    Arr::forget($item, 'updated_at');
                    Arr::forget($item, 'deleted_at');
                    Arr::forget($item, 'pivot');
                    Arr::forget($item, 'title');
                    Arr::forget($item, 'name');
                    Arr::forget($item, 'status');

                    $item->minimo = $item->minimum;
                    $item->maximo = $item->maximum;

                    Arr::forget($item, 'minimum');
                    Arr::forget($item, 'maximum');

                }
                break;
            case '5':
                foreach ($data as $item) {
                    Arr::forget($item, 'created_at');
                    Arr::forget($item, 'updated_at');
                    Arr::forget($item, 'deleted_at');
                    Arr::forget($item, 'pivot');
                    Arr::forget($item, 'minimum');
                    Arr::forget($item, 'maximum');
                }
                break;
            case '6':
                foreach ($data as $item) {
                    Arr::forget($item, 'created_at');
                    Arr::forget($item, 'updated_at');
                    Arr::forget($item, 'deleted_at');
                    Arr::forget($item, 'pivot');
                    Arr::forget($item, 'minimum');
                    Arr::forget($item, 'maximum');
                }
                break;
            case '7':
                foreach ($data as $item) {
                    Arr::forget($item, 'created_at');
                    Arr::forget($item, 'updated_at');
                    Arr::forget($item, 'deleted_at');
                    Arr::forget($item, 'pivot');
                    Arr::forget($item, 'minimum');
                    Arr::forget($item, 'maximum');
                    Arr::forget($item, 'status');
                }
                break;
            default:
                break;
        }
        $question->data = $data;
    }

    public function destroySection($id)
    {
        $section = TBSectionTemplateAnalisisRiesgoModel::find($id);

        $section->delete();

        return json_encode(['data' => 'Se elimino el registro exitosamente'], 200);
    }

    public function destroyQuestion($id)
    {
        $pivot = TBSectionTemplateAr_QuestionTemplateArModel::find($id);
        $question = TBQuestionTemplateAnalisisRiesgoModel::find($id);

        $question->delete();
        $pivot->delete();

        return json_encode(['data' => 'Se elimino el registro exitosamente'], 200);

    }

    public function destroyDataQuestion($id)
    {
        $pivot = TBQuestionTemplateAr_DataQuestionTemplateArModel::find($id);
        $dataQuestion = TBDataQuestionTemplateAnalisisRiesgoModel::find($id);

        $dataQuestion->delete();
        $pivot->delete();

        return json_encode(['data' => 'Se elimino el registro exitosamente'], 200);

    }

    public function getSettings(int $id){
        try {
            $template = TBTemplateAnalisisRiesgoModel::findOrFail($id);

            $sections = TBSectionTemplateAnalisisRiesgoModel::select('id', 'title', 'template_id', 'position')
                ->where('template_id', $template->id)->get();

            $formulas =TBFormulaTemplateAnalisisRiesgoModel::where('template_id',$id)->get();

            foreach($formulas as $formula){
                Arr::forget($formula, 'created_at');
                Arr::forget($formula, 'updated_at');
                Arr::forget($formula, 'deleted_at');
                Arr::forget($formula, 'template_id');
            }

            $questions = [];
            $optionId = ([
                'id'=> 'q-1',
                'title' => 'ID',
                'template' => $template->id,
                'position' => 0,
                'type' => "12",
                'size' => 3,
                'obligatory' => true,
                'data' => [],
            ]);

            $optionDescription = ([
                'id'=> 'q-2',
                'title' => 'Descripcion del riesgo',
                'template' => $template->id,
                'position' => 1,
                'type' => "12",
                'size' => 3,
                'obligatory' => true,
                'data' => [],
            ]);

            foreach ($sections as $index => $section) {
                $data = $section->questions;
                $sectionId = $section->id;
                if($index === 0){
                    $optionId['columnId'] = $sectionId;
                    $optionDescription['columnId'] = $sectionId;
                }
                $newQuestions = $data->map(function ($itm) use ($sectionId,$index, &$optionId) {
                    if($index === 0){
                        $itm['type'] === "11" ? $itm['position'] = $itm['position'] + 2 : null;
                        $itm['type'] !== "11" ? $itm['position'] = $itm['position'] + 2 : null;
                    }
                    if($itm['type'] !== "11"){
                        $position = $itm['position'];
                        $itm['position'] = $position + 1;
                    }
                    Arr::forget($itm, 'created_at');
                    Arr::forget($itm, 'updated_at');
                    Arr::forget($itm, 'pivot');
                    Arr::forget($itm, 'deleted_at');
                    $itm->columnId = $sectionId;
                    $this->getDataQuestion($itm);
                    return $itm;
                });

                Arr::forget($section, 'questions');

                foreach ($newQuestions as $newQuestion) {
                    array_push($questions, $newQuestion);
                }

            }
            array_push($questions, $optionId);
            array_push($questions, $optionDescription);

            return json_encode(['data' => ['sections' => $sections, 'questions' => $questions]], 200);

        } catch (\Throwable $th) {
            throw $th;

            return response()->json(['message' => 'No encontrado'], 404);
        }
    }

    public function getInfoTemplate(int $id){
        $register = TBTemplateAnalisisRiesgoModel::find($id);
        $template = ([
            'id' => $register->id,
            'title' => $register->nombre,
            'norma' => $register->norma->norma,
            'description' => $register->descripcion,
        ]);
        return json_encode(['data' => ['template' => $template]], 200);
    }

}