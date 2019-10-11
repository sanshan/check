<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
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
        return [
            'name'              => 'required|string|min:3|max:20',
            'patronymic'        => 'required|string|min:3|max:20',
            'surname'           => 'required|string|min:3|max:20',
            'phone'             => 'required|string|min:3|max:20',
            'email'             => 'required|email|unique:users,email',
            'role_id'           => 'required|integer|exists:roles,id',
            'region_id'         => 'required|array|min:1|exists:regions,id',
            'gas_station_id'    => 'required|array|min:1|exists:gas_stations,id'
        ];
    }
}
