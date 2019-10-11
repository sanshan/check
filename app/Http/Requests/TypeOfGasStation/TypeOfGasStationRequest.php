<?php

namespace App\Http\Requests\TypeOfGasStation;

use App\Http\Requests\ValidateRequest;

class TypeOfGasStationRequest extends ValidateRequest
{
    public function rules()
    {
        return [
            'title'        => 'required|string|max:100|unique:type_of_gas_stations,title',
            'abbreviation' => 'required|string|max:10|unique:type_of_gas_stations,abbreviation',
        ];
    }
}
