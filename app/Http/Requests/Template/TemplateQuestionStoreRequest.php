<?php

namespace App\Http\Requests\Template;

use Illuminate\Validation\Rule;

class TemplateQuestionStoreRequest extends TemplateRequest
{
    public function rules()
    {
        return [
            'questions'   => 'required|array|min:1',
            'question.*' => [
                'exists:questions,id',
                Rule::unique('question_template', 'question_id')->where('template_id', $this->route('template')),
            ],
        ];
    }
}
