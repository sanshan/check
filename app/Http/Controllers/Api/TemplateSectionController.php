<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Template\TemplateSectionDestroyRequest;
use App\Http\Requests\Template\TemplateSectionStoreRequest;
use App\Models\Template;

class TemplateSectionController extends BaseController
{

    public function store(TemplateSectionStoreRequest $request, Template $template)
    {
        $template->sections()->attach($request->sections);

        return $this->sendResponse('', __('Sections added to the template.'));
    }

    public function destroy(TemplateSectionDestroyRequest $request, Template $template)
    {
        $template->sections()->detach($request->sections);

        return $this->sendResponse('', __('Sections removed from the template.'));
    }
}
