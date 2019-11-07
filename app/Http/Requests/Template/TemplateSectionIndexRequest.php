<?php

namespace App\Http\Requests\Template;

class TemplateSectionIndexRequest extends TemplateRequest
{
    public function rules()
    {
        return [
            'missing_in_template' => 'filled|integer|exists:templates,id',
            'present_in_template' => 'filled|integer|exists:templates,id',
        ];
    }
}
