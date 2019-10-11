<?php

namespace App\Http\Requests\Task;

use App\Http\Requests\ValidateRequest;

class TaskRequest extends ValidateRequest
{
    public function rules()
    {
        return [
            'region_id'             => 'required|integer|exists:regions,id',
            'gas_station_id'        => 'required|integer|exists:gas_stations,id',
            'start_date'            => 'required|date_format:d.m.Y',
            'end_date'              => 'required|date_format:d.m.Y',
            'type_of_checklists_id' => 'required|integer|exists:type_of_checklists,id',
            'user_id'               => 'required|integer|exists:users,id',
        ];
    }
}
