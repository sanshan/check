<?php

namespace App\Http\Requests\TypeOfGasStation;

class TypeOfGasStationUpdateRequest extends TypeOfGasStationRequest
{
    public function rules()
    {
        return [
                'type_of_gas_station_id' => 'required|integer|exists:type_of_gas_stations,id',
                'title'                  => 'required|string|max:100|unique:type_of_gas_stations,title,' . $this->type_of_gas_station_id,
                'abbreviation'           => 'required|string|max:10|unique:type_of_gas_stations,abbreviation,' . $this->type_of_gas_station_id,
            ] + parent::rules();
    }
}
