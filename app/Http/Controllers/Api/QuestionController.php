<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Question\QuestionAvailableRequest;
use App\Http\Requests\Question\QuestionIndexRequest;
use App\Http\Requests\Question\QuestionStoreRequest;
use App\Http\Requests\Question\QuestionUpdateRequest;
use App\Http\Resources\Question\QuestionAvailableResource;
use App\Http\Resources\Question\QuestionDTResource;
use App\Http\Resources\Question\QuestionInfoResource;
use App\Http\Resources\Question\QuestionResource;
use App\Http\Resources\Question\QuestionSelect2Resource;
use App\Models\Question;
use App\Models\Template;
use DB;

class QuestionController extends Controller
{

    public function index(QuestionIndexRequest $request)
    {
        $questions = Question::filter($request)
            ->take(10)
            ->get();

        return QuestionSelect2Resource::collection($questions);

    }

    /**
     * @param QuestionIndexRequest $request
     * @return mixed
     * @throws \Exception
     */
    public function dataTableIndex(QuestionIndexRequest $request)
    {
        $questions = Question::with('positions')
            ->filter($request)
            ->get();

        return datatables()->of(QuestionDTResource::collection($questions))
            ->addColumn('DT_RowId', function ($row) {
                return 'row_' . $row['id'];
            })->toJson();

    }


    /**
     * @param QuestionStoreRequest $request
     * @return QuestionInfoResource
     * @throws \Throwable
     */
    public function store(QuestionStoreRequest $request): QuestionInfoResource
    {
        DB::transaction(function () use ($request) {
            $question = Question::create($request->validated());
            $question->positions()->attach($request->position_id);
        });
        return QuestionInfoResource::make($request);
    }

    /**
     * @param Question $question
     * @return QuestionResource
     */
    public function show(Question $question): QuestionResource
    {
        $question->load('positions');
        return QuestionResource::make($question);
    }

    /**
     * @param QuestionUpdateRequest $request
     * @param Question $question
     * @return QuestionInfoResource
     * @throws \Throwable
     */
    public function update(QuestionUpdateRequest $request, Question $question): QuestionInfoResource
    {
        DB::transaction(function () use ($request, $question) {
            $question->title = $request->title;
            $question->required = $request->required;
            $question->partly = $request->partly;
            $question->save();
            $question->positions()->sync($request->position_id);
        });
        return QuestionInfoResource::make($question);
    }

    /**
     * @param Question $question
     * @return QuestionInfoResource
     * @throws \Exception
     */
    public function destroy(Question $question): QuestionInfoResource
    {
        $question->delete();
        return QuestionInfoResource::make($question);
    }

    // Этот метод требует доработки. Надо выдать коллекцию вопросов, которые не присутствуют в шаблоне с $template->id
//    public function available(QuestionAvailableRequest $request, Template $template)
//    {
//        $template_id = $template->id;
//        $questions = Question::has('section')->with(['section', 'positions'])->get();
//        $questionsInTemplate = Question::whereHas('templates', function ($query) use ($template_id) {
//            $query->where('templates.id', '=', $template_id);
//        })->get();
//
//        //return response()->json($questionsInTemplate);
//
//        return datatables()->of(QuestionAvailableResource::collection($questions->diff($questionsInTemplate)))
//            ->addColumn('DT_RowId', function ($row) {
//                return 'row_' . $row['id'];
//            })->toJson();
//    }
}
