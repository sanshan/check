<?php

namespace App\Http\Requests\Template;

use Illuminate\Validation\Rule;

class TemplateSectionQuestionDestroyRequest extends TemplateRequest
{
    public function rules()
    {
        return [
            'ts'          => Rule::exists('section_template', 'id')->where('template_id', $this->route('template')->id),
            'questions'   => 'required|array|min:1',
            'questions.*' => Rule::exists('question_section_template', 'question_id')
                ->where('section_template_id', $this->ts),
        ];
    }

    public function all($keys = null)
    {
        $data = parent::all($keys);
        $data['ts'] = $this->route('ts')->id;
        return $data;
    }
}
