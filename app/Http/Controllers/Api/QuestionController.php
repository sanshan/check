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
use DB;

class QuestionController extends BaseController
{

    /**
     * @param QuestionIndexRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index(QuestionIndexRequest $request)
    {
        $questions = Question::filter($request)
            ->take(10)
            ->get();

        return $this->sendResponse(QuestionSelect2Resource::collection($questions), __('Data retrieved successfully.'));
    }

    /**
     * @param QuestionIndexRequest $request
     * @return mixed
     * @throws \Exception
     */
    //Надо убрать это отсюда
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
     * @return \Illuminate\Http\Response
     * @throws \Throwable
     */
    public function store(QuestionStoreRequest $request)
    {
        $question = DB::transaction(function () use ($request) {
            $question = Question::create($request->validated());
            $question->positions()->attach($request->position_id);
        });

        return $this->sendResponse(QuestionInfoResource::make($question), __('Data created successfully.'));
    }

    /**
     * @param Question $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        $question->load('positions');

        return $this->sendResponse(QuestionResource::make($question), __('Data retrieved successfully.'));
    }

    /**
     * @param QuestionUpdateRequest $request
     * @param Question $question
     * @return \Illuminate\Http\Response
     * @throws \Throwable
     */
    public function update(QuestionUpdateRequest $request, Question $question)
    {
        $question = DB::transaction(function () use ($request, $question) {
            $question->title = $request->title;
            $question->required = $request->required;
            $question->partly = $request->partly;
            $question->save();
            $question->positions()->sync($request->position_id);
        });

        return $this->sendResponse(QuestionInfoResource::make($question), __('Record updated successfully.'));
    }

    /**
     * @param Question $question
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Question $question)
    {
        $question->delete();

        return $this->sendResponse(QuestionInfoResource::make($question), __('Record deleted successfully.'));
    }

}
