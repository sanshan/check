<?php

namespace App\Http\Requests\Question;

class QuestionAvailableRequest extends QuestionRequest
{
    public function rules()
    {
        return [
            'section' => 'required|integer|exists:sections,id',
        ];
    }
}
