<?php

namespace App\Http\Requests\Question;

class QuestionIndexRequest extends QuestionRequest
{
    public function rules()
    {
        return [
            'missing_in_section_template' => 'filled|integer|exists:section_template,id',
        ];
    }
}
