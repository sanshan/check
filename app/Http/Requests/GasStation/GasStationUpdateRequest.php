<?php

namespace App\Http\Requests\GasStation;

class GasStationUpdateRequest extends GasStationRequest
{
    public function rules()
    {
        return [
                'gas_station_id' => 'required|integer|exists:gas_stations,id',
                'number'         => 'required|integer|unique:gas_stations,number,' . $this->gas_station_id,
            ] + parent::rules();
    }
}
