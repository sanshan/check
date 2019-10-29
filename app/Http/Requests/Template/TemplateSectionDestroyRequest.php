<?php

namespace App\Http\Requests\Template;

use Illuminate\Validation\Rule;

class TemplateSectionDestroyRequest extends TemplateRequest
{
    public function rules()
    {
        return [
            'sections'   => 'required|array|min:1',
            'sections.*' => Rule::exists('section_template', 'section_id')->where('template_id', $this->route('template')->id),
        ];
    }
}
