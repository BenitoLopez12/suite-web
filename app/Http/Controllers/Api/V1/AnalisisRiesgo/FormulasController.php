<?php

namespace App\Http\Controllers\Api\v1\AnalisisRiesgo;

use App\Http\Controllers\Controller;
use App\Models\TBSectionTemplateAnalisisRiesgoModel;
use App\Models\TBQuestionTemplateAnalisisRiesgoModel;
use App\Models\TBFormulaTemplateAnalisisRiesgoModel;
use App\Models\TBTemplateAnalisisRiesgoModel;
use App\Models\TBSectionTemplateAr_QuestionTemplateArModel;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class FormulasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $newFormula = $request->input('formula');
        $this->saveFormula($newFormula);
        return json_encode(['data' => 'Se crearon exitosamente las formulas'], 200);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $formulas =TBFormulaTemplateAnalisisRiesgoModel::where('template_id',$id)->orderBy('id')->get();
        foreach($formulas as $formula){
            Arr::forget($formula, 'created_at');
            Arr::forget($formula, 'updated_at');
            Arr::forget($formula, 'deleted_at');
            Arr::forget($formula, 'template_id');
        }
        return json_encode(['data' => ['formulas'=>$formulas]], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $formulas = $request->input('formulas');

        foreach($formulas as $formula){
            try {
                DB::beginTransaction();
                $register = TBFormulaTemplateAnalisisRiesgoModel::findOrFail($formula['id']);
                $pivotQuestion = TBSectionTemplateAr_QuestionTemplateArModel::where('question_id',$formula['question_id'])->first();
                $pivot = TBSectionTemplateAr_QuestionTemplateArModel::findOrFail($pivotQuestion->id);

                $register->update([
                    'title' => $formula['title'],
                    'riesgo' => $formula['riesgo'],
                    'section_id' => $formula['section_id'],
                ]);

                $pivot->update([
                    'section_id' => $formula['section_id'],
                ]);

                DB::commit();
            } catch (\Throwable $th) {
                //throw $th;
                DB::rollback();
                continue;
            }
        }

        return json_encode(['data' => 'Se actualizaron exitosamente los registros']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $formula = TBFormulaTemplateAnalisisRiesgoModel::findOrFail($id);
        $question = TBQuestionTemplateAnalisisRiesgoModel::findOrFail($formula->question_id);
        $pivotQuestion = TBSectionTemplateAr_QuestionTemplateArModel::where('question_id',$formula->question_id)->first();
        $pivot = TBSectionTemplateAr_QuestionTemplateArModel::findOrFail($pivotQuestion->id);

        $question->delete();
        $pivot->delete();
        $formula->delete();

        return json_encode(['data' => 'Se elimino el registro exitosamente'], 200);
    }

    public function filterOptions(&$options, $questions){
        foreach($questions as $question){
            $newQuestion = $question;

            Arr::forget($newQuestion, 'created_at');
            Arr::forget($newQuestion, 'updated_at');
            Arr::forget($newQuestion, 'pivot');
            Arr::forget($newQuestion, 'deleted_at');
            Arr::forget($newQuestion, 'size');
            Arr::forget($newQuestion, 'position');
            Arr::forget($newQuestion, 'obligatory');

            switch($question->type){
                case '3':
                    Arr::forget($newQuestion, 'type');
                    array_push($options, $newQuestion);
                    break;
                case '6':
                    Arr::forget($newQuestion, 'type');
                    array_push($options, $newQuestion);
                    break;
                default:
            }
        }
    }

    public function getOptionsFormulas($id){
        $sections = TBSectionTemplateAnalisisRiesgoModel::where('template_id',$id)->get();
        $options = [];

        foreach($sections as $section){
            $questions = $section->questions;

            $this->filterOptions($options,$questions);
        }

        return json_encode(['data' => ['options' => $options]], 200);
    }

    public function saveFormula($newFormula){
        // foreach($newFormulas as $newFormula){
            try {
                DB::beginTransaction();

                $questionCreate = TBQuestionTemplateAnalisisRiesgoModel::create([
                    'title' => $newFormula['title'],
                    'size' => 3,
                    'type' => "11",
                    'position' => 0,
                    'obligatory' => true,
                ]);

                TBSectionTemplateAr_QuestionTemplateArModel::create([
                    'section_id' => $newFormula['section_id'],
                    'question_id' => $questionCreate->id,
                ]);

                TBFormulaTemplateAnalisisRiesgoModel::create([
                    'title'=> $newFormula['title'],
                    'formula' => $newFormula['formula'],
                    'riesgo' => $newFormula['riesgo'],
                    'template_id' => $newFormula['template_id'],
                    'section_id' => $newFormula['section_id'],
                    'question_id' => $questionCreate->id,
                ]);
                DB::commit();
            } catch (\Throwable $th) {
                //throw $th;
                dd($th);
                DB::rollback();
                // continue;
            }
        // }
    }

    public function getSections(int $id){
        try {
            $template = TBTemplateAnalisisRiesgoModel::findOrFail($id);
            $sections = TBSectionTemplateAnalisisRiesgoModel::select('id', 'title')
                ->where('template_id', $template->id)->get();
            return json_encode(['data' => ['sections'=>$sections]], 200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['message' => 'No encontrado'], 404);
        }

    }

}