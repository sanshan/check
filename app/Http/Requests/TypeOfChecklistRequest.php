<?php

namespace App\Http\Requests;

use App\Traits\RequestMessages;
use Illuminate\Foundation\Http\FormRequest;

class TypeOfChecklistRequest extends FormRequest
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
            'title' => 'required|string|max:100|unique:type_of_checklists,title',
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
                    'type_of_checklist_id' => 'required|integer|exists:type_of_checklists,id',
                    'title' => 'required|string|max:100|unique:type_of_checklists,title,'.$this->type_of_checklist_id,
                ] + $rules;
            //case 'DELETE':
        }
    }
}
