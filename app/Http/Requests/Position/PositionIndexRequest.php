<?php

namespace App\Http\Requests\Position;

class PositionIndexRequest extends PositionRequest
{
    public function rules()
    {
        return [
            'title' => 'nullable|string|max:100',
        ];
    }
}
