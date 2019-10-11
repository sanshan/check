<?php

namespace App\Http\Requests\Position;

use App\Http\Requests\ValidateRequest;

class PositionRequest extends ValidateRequest
{
    public function rules()
    {
        return [
            'title'   => 'required|string|max:100|unique:positions,title',
            'code'    => 'required|string|max:10',
            'to_rate' => 'required|boolean',
        ];
    }
}
