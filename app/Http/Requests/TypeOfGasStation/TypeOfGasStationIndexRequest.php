<?php

namespace App\Http\Requests\TypeOfGasStation;

class TypeOfGasStationIndexRequest extends TypeOfGasStationRequest
{
    public function rules()
    {
        return [
            'title' => 'nullable|string|max:20',
        ];
    }
}
