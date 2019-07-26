<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PositionRequest extends FormRequest
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
        $rules = [
            'title' => 'required|string|max:100|unique:positions,title',
            'code' => 'required|string|max:10',
            'to_rate' => 'required|boolean'
        ];

        switch($this->getMethod())
        {
            case 'POST':
                return $rules;
            case 'PATCH':
            case 'PUT':
                return [
                    'position_id' => 'required|integer|exists:positions,id',
                    'title' => 'required|string|max:100|unique:positions,title,'.$this->position_id
                ] + $rules;
            //case 'DELETE':
        }
    }

    public function messages()
    {
        return [
            'title.required' => 'Поле "Название" обязательно для заполнения',
            'title.max'  => 'В поле "Название" может быть не более 100 символов',
            'title.unique'  => 'Такое название уже существует',
            'region_id.required'  => 'Не указан ID должности',
            'region_id.exists'  => 'ID должности не найден',
        ];
    }
}
