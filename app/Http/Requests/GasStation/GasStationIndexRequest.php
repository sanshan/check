<?php

namespace App\Http\Requests\GasStation;

class GasStationIndexRequest extends GasStationRequest
{
    public function rules()
    {
        return [
            'number'             => 'nullable|string|max:100',
            'gas_station_region' => 'filled|integer|exists:regions,id',
        ];
    }
}
