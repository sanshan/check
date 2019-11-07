<?php

namespace App\Http\Requests\Template;

class TemplateSectionUpdateRequest extends TemplateRequest
{
    public function rules()
    {
        return [
            'weight' => 'required|integer',
        ];
    }
}
