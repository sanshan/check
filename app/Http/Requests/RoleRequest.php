<?php

namespace App\Http\Requests;

use App\Traits\RequestMessages;
use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
            'title' => 'required|string|max:100|unique:roles,title',
        ];

        switch($this->getMethod())
        {
            case 'GET':
                return [
                    'number' => 'nullable|string|max:10'
                ];
            case 'POST':
                return $rules;
            case 'PATCH':
            case 'PUT':
                return [
                    'role_id' => 'required|integer|exists:roles,id',
                    'title' => 'required|string|max:100|unique:roles,title,'.$this->role_id,
                ];
            //case 'DELETE':
        }
    }
}
