<?php

namespace App\Http\Requests;

use App\Traits\RequestMessages;
use Illuminate\Foundation\Http\FormRequest;

class SectionRequest extends FormRequest
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
            'title' => 'required|string|max:100|unique:sections,title',
        ];

        switch($this->getMethod())
        {
            case 'GET':
                return [
                    'title' => 'filled|string|max:100',
                ];
            case 'POST':
                return $rules;
            case 'PATCH':
            case 'PUT':
                return [
                    'section_id' => 'required|integer|exists:sections,id',
                    'title' => 'required|string|max:100|unique:sections,title,'.$this->section_id,
                ];
            //case 'DELETE':
        }

    }

}
