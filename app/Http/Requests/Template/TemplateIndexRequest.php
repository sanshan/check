<?php

namespace App\Http\Requests\Template;

class TemplateIndexRequest extends TemplateRequest
{
    public function rules()
    {
        return [
            'title' => 'nullable|string|max:10',
        ];
    }
}
