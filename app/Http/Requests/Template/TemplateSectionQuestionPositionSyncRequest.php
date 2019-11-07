<?php

namespace App\Http\Requests\Template;

class TemplateSectionQuestionPositionSyncRequest extends TemplateRequest
{
    public function rules()
    {
        return [
            'positions'   => 'required|array|min:1',
            'positions.*' => 'exists:positions,id',
        ];
    }
}
