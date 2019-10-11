<?php

namespace App\Http\Requests\Question;

class QuestionUpdateRequest extends QuestionRequest
{
    public function rules()
    {
        return [
                'question_id' => 'required|integer|exists:questions,id',
                'title'       => 'required|string|max:500|unique:questions,title,' . $this->question_id,
            ] + parent::rules();
    }
}
