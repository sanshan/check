<?php

namespace App\Http\Requests;

use App\Traits\RequestMessages;
use Illuminate\Foundation\Http\FormRequest;

class GasStationRequest extends FormRequest
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
            'region_id' => 'required|integer|exists:regions,id',
            'type_of_gas_station_id' => 'required|integer|exists:type_of_gas_stations,id',
            'number' => 'required|integer|unique:gas_stations,number',
            'address' => 'required|string|max:500',
            'is_shop' => 'required|boolean',
            'it_works' => 'required|boolean',
            'dir_name' => 'required|string|max:20',
            'dir_patronymic' => 'required|string|max:20',
            'dir_surname' => 'required|string|max:20',
            'email' => 'required|string|max:50',
            'phone' => 'required|string|max:20',
        ];

        switch($this->getMethod())
        {
            case 'GET':
                return [
                    'title' => 'nullable|string|max:100'
                ];
            case 'POST':
                return $rules;
            case 'PATCH':
            case 'PUT':
                return [
                    'gas_station_id' => 'required|integer|exists:gas_stations,id',
                    'number' => 'required|integer|unique:gas_stations,number,'.$this->gas_station_id,
                ] + $rules;
            //case 'DELETE':
        }
    }
}
