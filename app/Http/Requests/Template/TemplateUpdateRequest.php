<?php

namespace App\Http\Requests\Template;

class TemplateUpdateRequest extends TemplateRequest
{
    public function rules()
    {
        return [
                'template_id' => 'required|integer|exists:templates,id',
            ] + parent::rules();
    }
}
