<?php

namespace App\Http\Requests\Template;

use Illuminate\Validation\Rule;

class removeQuestionRequest extends TemplateRequest
{
    public function rules()
    {
        return [
            'template_id'   => 'required|integer|exists:templates,id',
            'question_id'   => 'required|array|min:1',
            'question_id.*' => [
                Rule::exists('question_template', 'question_id')->where('template_id', $this->template_id),
            ],
        ];
    }
}
