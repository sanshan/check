<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Template\TemplateSectionQuestionPositionSyncRequest;
use App\Http\Resources\Position\PositionSelect2Resource;
use App\Models\Template;
use App\Models\TemplateSectionPivot;
use App\Models\TemplateSectionQuestionPivot;

class TemplateSectionQuestionPositionController extends BaseController
{
    public function index(Template $template, TemplateSectionPivot $ts, TemplateSectionQuestionPivot $tsq)
    {
        $positions = $tsq->positions;

        return $this->sendResponse(PositionSelect2Resource::collection($positions), __('Data retrieved successfully.'));
    }

    public function update(TemplateSectionQuestionPositionSyncRequest $request, Template $template, TemplateSectionPivot $ts, TemplateSectionQuestionPivot $tsq)
    {
        $tsq->positions()->sync($request->positions);

        return $this->sendResponse('', __('Positions synced.'));
    }

}
