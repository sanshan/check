<?php

namespace App\Http\Requests\GasStation;

use App\Http\Requests\ValidateRequest;

class GasStationRequest extends ValidateRequest
{
    public function rules()
    {
        return [
            'region_id'              => 'required|integer|exists:regions,id',
            'type_of_gas_station_id' => 'required|integer|exists:type_of_gas_stations,id',
            'number'                 => 'required|integer|unique:gas_stations,number',
            'address'                => 'required|string|max:500',
            'is_shop'                => 'required|boolean',
            'it_works'               => 'required|boolean',
            'dir_name'               => 'required|string|max:20',
            'dir_patronymic'         => 'required|string|max:20',
            'dir_surname'            => 'required|string|max:20',
            'email'                  => 'required|string|max:50',
            'phone'                  => 'required|string|max:20',
        ];
    }
}
