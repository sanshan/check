<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Template\TemplateSectionQuestionPositionSyncRequest;
use App\Models\Question;
use App\Models\Section;
use App\Models\Template;

class TemplateSectionQuestionPositionController extends BaseController
{
    public function update(TemplateSectionQuestionPositionSyncRequest $request, Template $template, Section $section, Question $question)
    {
        $template->sections()
            ->where('sections.id',$section->id)
            ->first()
            ->pivot
            ->questions()
            ->where('questions.id',$question->id)
            ->first()
            ->pivot
            ->positions()
            ->sync($request->positions);


        return $this->sendResponse('', __('Positions synced.'));
    }

}
