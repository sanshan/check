<?php

namespace App\Http\Requests\Template;

class templateQuestionPositionUpdateRequest extends TemplateRequest
{
    public function rules()
    {
        return [
            'positions'   => 'required|array|min:1',
            'positions.*' => 'integer|exists:positions,id',
        ];
    }
}
