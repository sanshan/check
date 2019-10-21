<?php

namespace App\Http\Requests\Question;

class QuestionIndexRequest extends QuestionRequest
{
    public function rules()
    {
        return [
            'section'             => 'filled|integer|exists:sections,id',
            'title'               => 'nullable|string|max:100',
            'missing_in_template' => 'nullable|integer|exists:templates,id',
            'present_in_template' => 'nullable|integer|exists:templates,id',
        ];
    }
}
