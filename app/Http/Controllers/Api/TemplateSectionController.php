<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Template\TemplateSectionDestroyRequest;
use App\Http\Requests\Template\TemplateSectionStoreRequest;
use App\Http\Requests\Template\TemplateSectionUpdateRequest;
use App\Http\Resources\Section\SectionDTResource;
use App\Models\Section;
use App\Models\Template;
use Illuminate\Database\QueryException;

class TemplateSectionController extends BaseController
{
    public function index(Template $template)
    {
        $sections = $template->sections;

        return datatables()->of(SectionDTResource::collection($sections))
            ->addColumn('DT_RowId', function ($row) {
                return 'row_' . $row['id'];
            })
            ->toJson();
    }

    public function store(TemplateSectionStoreRequest $request, Template $template)
    {
        try {$template->attachSections($request->sections);}
        catch(QueryException $exception){return $this->sendError('', '', 500);}
        return $this->sendResponse('', __('Sections added to the template.'));
    }

    public function update(TemplateSectionUpdateRequest $request, Template $template, Section $section)
    {
        $pivot = $template->sections()->where('sections.id', $section->id)->first()->pivot;
        $pivot->weight = $request->weight;
        $pivot->save();

        return $this->sendResponse('', __('Section weight updated'));
    }

    public function destroy(TemplateSectionDestroyRequest $request, Template $template)
    {
        $template->sections()->detach($request->sections);

        return $this->sendResponse('', __('Sections removed from the template.'));
    }
}
