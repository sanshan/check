<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Template\TemplateQuestionDestroyRequest;
use App\Http\Requests\Template\TemplateQuestionStoreRequest;
use App\Models\Template;

class TemplateQuestionController extends BaseController
{
    /**
     * @param TemplateQuestionStoreRequest $request
     * @param Template $template
     * @return \Illuminate\Http\Response
     */
    public function store(TemplateQuestionStoreRequest $request, Template $template)
    {
        $template->questions()->attach($request->questions);

        return $this->sendResponse('', __('Questions are added to the template.'));
    }

    /**
     * @param TemplateQuestionDestroyRequest $request
     * @param Template $template
     * @return \Illuminate\Http\Response
     */
    public function destroy(TemplateQuestionDestroyRequest $request, Template $template)
    {
        $template->questions()->detach($request->questions);

        return $this->sendResponse('', __('Questions removed from the template.'));
    }

}
