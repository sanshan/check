<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Template\TemplateSectionQuestionDestroyRequest;
use App\Http\Requests\Template\TemplateSectionQuestionStoreRequest;
use App\Http\Resources\Template\TemplateSectionQuestionDTIndexResource;
use App\Models\Section;
use App\Models\Template;

class TemplateSectionQuestionController extends BaseController
{
    public function index(Template $template, Section $section)
    {
        $template->load('sections.pivot.questions.pivot.positions');
        $questions = $template->sections()->where('sections.id', $section->id)->first()->pivot->questions;

        return datatables()->of(TemplateSectionQuestionDTIndexResource::collection($questions))
            ->addColumn('DT_RowId', function ($row) {
                return 'row_' . $row['id'];
            })
            ->toJson();
    }

    public function store(TemplateSectionQuestionStoreRequest $request, Template $template, Section $section)
    {
        $template->sections()->where('sections.id', $section->id)->firstOrFail()->pivot->questions()->attach($request->questions);

        return $this->sendResponse('', __('Questions added to the template.'));
    }

    public function destroy(TemplateSectionQuestionDestroyRequest $request, Template $template, Section $section)
    {
        $template->sections()->where('sections.id', $section->id)->firstOrFail()->pivot->questions()->detach($request->questions);

        return $this->sendResponse('', __('Questions removed from the template.'));
    }

}
