<?php

namespace App\Http\Requests\Template;

use App\Http\Requests\ValidateRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TemplateRequest extends ValidateRequest
{
    public function rules()
    {
        $rules = [
            'type_of_gas_station_id' => 'required|array|min:1',
            'type_of_gas_station_id.*' => 'exists:type_of_gas_stations,id',
            'type_of_checklist_id' => 'required|integer|exists:type_of_checklists,id',
            'region_id' => 'required|array|min:1',
            'region_id.*' => 'exists:regions,id',
            'it_works' => 'required|boolean',
        ];

        switch ($this->getMethod())
        {
            case 'GET':
                return [
                    'title' => 'nullable|string|max:100',
                ];
            case 'POST':
                return $rules;
            case 'PATCH':
                return [
                    'position_id' => 'required|array|min:1',
                    'position_id.*' => 'exists:positions,id',
                ];
            case 'PUT':
                return [
                    'template_id' => 'required|integer|exists:templates,id',
                ] + $rules;
            //case 'DELETE':
        }
    }
}
