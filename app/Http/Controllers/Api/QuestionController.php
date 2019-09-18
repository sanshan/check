<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionRequest;
use App\Http\Resources\QuestionResource;
use App\Http\Resources\QuestionDTResource;
use App\Question;
use App\Template;
use Exception;
use DB;
use Throwable;


class QuestionController extends Controller
{

    /**
     * @param QuestionRequest $request
     * @return mixed
     * @throws Exception
     */
    public function index(QuestionRequest $request)
    {
        $title = $request->input('title');
        $section = $request->input('section');

        $questions = Question::with('positions')
            ->when($title, function ($query) use ($title){
                return $query->where('title', 'LIKE', "%$title%");
            })
            ->when($section, function ($query) use ($section){
                return $query->where('section_id', $section);
            })
            ->withCount(['section', 'positions'])
            ->get();

        return
            $title
                ? QuestionResource::collection($questions)
                : datatables()->of(QuestionDTResource::collection($questions))
                ->addColumn('DT_RowId', function($row){
                    return 'row_'.$row['id'];
                })->toJson();

    }

    /**
     * @param QuestionRequest $request
     * @return QuestionResource
     * @throws Throwable
     */
    public function store(QuestionRequest $request) : QuestionResource
    {
        $question = DB::transaction(function () use ($request){
            $question = Question::create($request->validated());
            $question->positions()->attach($request->position_id);
        });
        return QuestionResource::make($question);
    }

    /**
     * @param Question $question
     * @return QuestionResource
     */
    public function show(Question $question) : QuestionResource
    {
        $question->load('positions');
        return QuestionResource::make($question);
    }


    public function update(QuestionRequest $request, Question $question) : QuestionResource
    {
        DB::transaction(function () use($request, $question) {
            $question->title = $request->title;
            $question->required = $request->required;
            $question->partly = $request->partly;
            $question->save();
            $question->positions()->sync($request->position_id);
        });
        return QuestionResource::make($question);
    }

    /**
     * @param Question $question
     * @return QuestionResource
     * @throws Exception
     */
    public function destroy(Question $question) : QuestionResource
    {
        $question->delete();
        return QuestionResource::make($question);
    }


    /**
     * @param Template $template
     * @return mixed
     * @throws Exception
     */
    public function available(Template $template)
    {
        $questions = Question::has('section')->with(['section', 'positions'])->get();
        return datatables()->of(QuestionResource::collection($questions->diff($template->questions)))
                ->addColumn('DT_RowId', function($row){
                    return 'row_'.$row['id'];
                })->toJson();
    }
}
