<?php

namespace App\Http\Requests;

use App\Traits\RequestMessages;
use Illuminate\Foundation\Http\FormRequest;

class RegionRequest extends FormRequest
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
            'title' => 'required|string|max:100|unique:regions,title',
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
                    'region_id' => 'required|integer|exists:regions,id',
                    'title' => 'required|string|max:100|unique:regions,title,'.$this->region_id,
                ];
            //case 'DELETE':
        }

    }
}
