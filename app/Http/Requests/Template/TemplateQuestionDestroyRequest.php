<?php

namespace App\Http\Requests\Template;

use Illuminate\Validation\Rule;

class TemplateQuestionDestroyRequest extends TemplateRequest
{
    public function rules()
    {
        return [
            'questions'   => 'required|array|min:1',
            'questions.*' => [
                Rule::exists('question_template', 'question_id')->where('template_id', $this->route('template')),
            ],
        ];
    }
}
