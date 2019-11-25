<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Template\TemplateSectionQuestionDestroyRequest;
use App\Http\Requests\Template\TemplateSectionQuestionStoreRequest;
use App\Http\Resources\Template\TemplateSectionQuestionDTIndexResource;
use App\Models\Template;
use App\Models\TemplateSectionPivot;

class TemplateSectionQuestionController extends BaseController
{
    public function index(Template $template, TemplateSectionPivot $ts)
    {
        $questions = $ts->questions;

        return datatables()->of(TemplateSectionQuestionDTIndexResource::collection($questions))
            ->addColumn('DT_RowId', function ($row) {
                return 'row_' . $row['id'];
            })
            ->toJson();
    }

    public function store(TemplateSectionQuestionStoreRequest $request, Template $template, TemplateSectionPivot $ts)
    {
        $ts->attachQuestions($request->questions);

        return $this->sendResponse('', __('Questions added to the template.'));
    }

    public function destroy(TemplateSectionQuestionDestroyRequest $request, Template $template, TemplateSectionPivot $ts)
    {
        $ts->detachQuestions($request->questions);

        return $this->sendResponse('', __('Questions removed from the template.'));
    }

}
