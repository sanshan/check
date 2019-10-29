<?php

namespace App\Http\Requests\Template;

use App\Http\Requests\ValidateRequest;

class TemplateRequest extends ValidateRequest
{
    public function rules()
    {
        return [
            'type_of_gas_station_id' => 'required|array|min:1',
            'type_of_gas_station_id.*' => 'exists:type_of_gas_stations,id',
            'type_of_checklist_id' => 'required|integer|exists:type_of_checklists,id',
            'regions' => 'required|array|min:1',
            'regions.*' => 'exists:regions,id',
            'it_works' => 'required|boolean',
        ];
    }
}
