<?php

namespace App\Http\Requests;

use App\Traits\RequestMessages;
use Illuminate\Foundation\Http\FormRequest;

class QuestionRequest extends FormRequest
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
        $rules =[
            'section_id' => 'required|integer|exists:sections,id',
            'title' => 'required|string|max:100|unique:questions,title',
            'position_id' => 'required|array|min:1|exists:positions,id',
            'required' => 'required|boolean',
            'partly' => 'required|boolean',
        ];

        switch($this->getMethod())
        {
            case 'GET':
                return [
                    'section' => 'filled|integer|exists:sections,id',
                    'title' => 'nullable|string|max:100',
                ];
            case 'POST':
                return $rules;
            case 'PATCH':
            case 'PUT':
                return [
                    'title' => 'required|string|max:100|unique:questions,title,'.$this->question_id,
                ] + $rules;
            //case 'DELETE':
        }

    }

}
