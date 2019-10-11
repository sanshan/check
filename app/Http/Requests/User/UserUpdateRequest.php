<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'user_id'           => 'required|integer|exists:users,id',
            'email'             => 'required|email|unique:users,email,'.$this->user_id,
            'name'              => 'required|string|min:3|max:20',
            'patronymic'        => 'required|string|min:3|max:20',
            'surname'           => 'required|string|min:3|max:20',
            'phone'             => 'required|string|min:3|max:20',
            'role_id'           => 'required|integer|exists:roles,id',
            'region_id'         => 'required|array|min:1|exists:regions,id',
            'gas_station_id'    => 'required|array|min:1|exists:gas_stations,id'
        ];
    }
}
