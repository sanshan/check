<?php

namespace App\Http\Requests\Template;

use App\Http\Requests\ValidateRequest;

class TemplateRequest extends ValidateRequest
{
    public function rules()
    {
        return [
            'types_of_gas_station'   => 'required|array|min:1',
            'types_of_gas_station.*' => 'exists:type_of_gas_stations,id',
            'type_of_checklist'      => 'required|integer|exists:type_of_checklists,id',
            'regions'                => 'required|array|min:1',
            'regions.*'              => 'exists:regions,id',
            'status'                 => 'required|boolean',
        ];
    }
}
