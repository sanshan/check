<?php

namespace App\Http\Requests;

use App\Traits\RequestMessages;
use Illuminate\Foundation\Http\FormRequest;

class PositionRequest extends FormRequest
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
            'title' => 'required|string|max:100|unique:positions,title',
            'code' => 'required|string|max:10',
            'to_rate' => 'required|boolean',
        ];

        switch($this->getMethod())
        {
            case 'GET':
                return [
                    'title' => 'nullable|string|max:100',
                ];
            case 'POST':
                return $rules;
            case 'PATCH':
            case 'PUT':
                return [
                    'position_id' => 'required|integer|exists:positions,id',
                    'title' => 'required|string|max:100|unique:positions,title,'.$this->position_id,
                ] + $rules;
            //case 'DELETE':
        }
    }
}
