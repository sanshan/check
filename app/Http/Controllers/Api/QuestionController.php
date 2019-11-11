<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Question\QuestionIndexRequest;
use App\Http\Requests\Question\QuestionStoreRequest;
use App\Http\Requests\Question\QuestionUpdateRequest;
use App\Http\Resources\Question\QuestionDTResource;
use App\Http\Resources\Question\QuestionInfoResource;
use App\Http\Resources\Question\QuestionResource;
use App\Http\Resources\Question\QuestionSelect2Resource;
use App\Models\Question;
use App\Models\Section;
use DB;

class QuestionController extends BaseController
{

    /**
     * @param Section $section
     * @return \Illuminate\Http\Response
     */
    public function index(Section $section)
    {
        $questions = Question::fromSection($section->id)
            ->take(10)
            ->get();

        return $this->sendResponse(QuestionSelect2Resource::collection($questions), __('Data retrieved successfully.'));
    }

    /**
     * @param QuestionIndexRequest $request
     * @param Section $section
     * @return mixed
     * @throws \Exception
     */
    //Надо убрать это отсюда
    public function dataTableIndex(QuestionIndexRequest $request, Section $section)
    {
        $questions = Question::with('positions')->filter($request)
            ->get();

        return datatables()->of(QuestionDTResource::collection($questions))
            ->addColumn('DT_RowId', function ($row) {
                return 'row_' . $row['id'];
            })->toJson();

    }

    /**
     * @param QuestionStoreRequest $request
     * @return \Illuminate\Http\Response
     * @throws \Throwable
     */
    public function store(QuestionStoreRequest $request)
    {
        $question = DB::transaction(function () use ($request) {
            $question = Question::create([
                'title'      => $request->title,
                'section_id' => $request->route('section'),
                'required'   => $request->required,
                'partly'     => $request->partly,

            ]);
            $question->positions()->attach($request->position_id);

            return $question;
        });

        return $this->sendResponse(QuestionInfoResource::make($question), __('Record created successfully.'));
    }

    public function show($section, $question)
    {
        $question = Question::with('positions')
            ->from($section)
            ->findOrFail($question);

        return $this->sendResponse(QuestionResource::make($question), __('Data retrieved successfully.'));
    }

    /**
     * @param QuestionUpdateRequest $request
     * @param $section
     * @param Question $question
     * @return \Illuminate\Http\Response
     */
    public function update(QuestionUpdateRequest $request, $section, $question)
    {
        $question = Question::from($section)
            ->findOrFail($question);

        $question = DB::transaction(function () use ($request, $question) {
            $question->title = $request->title;
            $question->required = $request->required;
            $question->partly = $request->partly;
            $question->save();
            $question->positions()->sync($request->position_id);

            return $question;
        });

        return $this->sendResponse(QuestionInfoResource::make($question), __('Record updated successfully.'));
    }

    /**
     * @param $section
     * @param $question
     * @return \Illuminate\Http\Response
     */
    public function destroy($section, $question)
    {
        $question = Question::from($section)
            ->findOrFail($question);
        //Можно сразу удалить, но тогда не получается вернуть информацию об удалённой записи
        $question->delete();

        return $this->sendResponse(QuestionInfoResource::make($question), __('Record deleted successfully.'));
    }

}

