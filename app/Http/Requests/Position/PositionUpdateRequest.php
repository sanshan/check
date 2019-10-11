<?php

namespace App\Http\Requests\Position;

class PositionUpdateRequest extends PositionRequest
{
    public function rules()
    {
        return [
                'position_id' => 'required|integer|exists:positions,id',
                'title'       => 'required|string|max:100|unique:positions,title,' . $this->position_id,
            ] + parent::rules();
    }
}
