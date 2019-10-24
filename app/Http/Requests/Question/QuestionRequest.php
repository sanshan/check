<?php

namespace App\Http\Requests\Question;

use App\Http\Requests\ValidateRequest;

class QuestionRequest extends ValidateRequest
{
    public function rules()
    {
        return [
            'title'       => 'required|string|max:500|unique:questions,title',
            'position_id' => 'required|array|min:1|exists:positions,id',
            'required'    => 'required|boolean',
            'partly'      => 'required|boolean',
        ];
    }
}
