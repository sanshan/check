<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Template\templateQuestionPositionUpdateRequest;
use App\Http\Resources\Position\PositionResource;
use App\Models\Question;
use App\Models\Template;

class TemplateQuestionPositionController extends BaseController
{

    /**
     * @param Template $template
     * @param Question $question
     * @return \Illuminate\Http\Response
     */
    public function index(Template $template, Question $question)
    {
        $positions = $template->questions()
            ->where('questions.id', $question->id)
            ->with('pivot.positions')
            ->first()
            ->pivot
            ->positions;

        return $this->sendResponse(PositionResource::collection($positions), __('Data retrieved successfully.'));
    }

    /**
     * @param templateQuestionPositionUpdateRequest $request
     * @param Template $template
     * @param Question $question
     * @return \Illuminate\Http\Response
     */
    public function store(templateQuestionPositionUpdateRequest $request, Template $template, Question $question)
    {
        $template->questions()
            ->where('questions.id', $question->id)
            ->with('pivot.positions')
            ->first()
            ->pivot
            ->positions()
            ->sync($request->positions);

        return $this->sendResponse('', __('Checked post categories saved.'));
    }
}
