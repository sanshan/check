<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\RequestMessages;

class TypeOfGasStationRequest extends FormRequest
{

    use RequestMessages;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'title' => 'required|string|max:100|unique:type_of_gas_stations,title',
            'abbreviation' => 'required|string|max:10',
        ];

        switch($this->getMethod())
        {
            case 'POST':
                return $rules;
            case 'PATCH':
            case 'PUT':
                return [
                    'title' => 'required|string|max:100|unique:type_of_gas_stations,title,'.$this->type_of_gas_station_id,
                    'type_of_gas_station_id' => 'required|integer|exists:type_of_gas_stations,id',
                ] + $rules;
            //case 'DELETE':
        }
    }
}
