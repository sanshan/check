<?php

namespace App\Http\Requests\Template;

class updatePositionRequest extends TemplateRequest
{
    public function rules()
    {
        return [
            'question_id'   => 'required|integer|exists:questions,id',
            'position_id'   => 'required|array|min:1',
            'position_id.*' => 'exists:positions,id',
        ];
    }
}
