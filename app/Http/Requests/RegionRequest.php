<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegionRequest extends FormRequest
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
            'title' => 'required|string|max:100|unique:regions,title',
        ];

        switch($this->getMethod())
        {
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

    public function messages()
    {
        return [
            'title.required' => 'Поле "Название" обязательно для заполнения',
            'title.max'  => 'В поле "Название" может быть не более 100 символов',
            'title.unique'  => 'Такое название уже существует',
            'region_id.required'  => 'Не указан ID региона',
            'region_id.exists'  => 'ID региона не найден',
        ];
    }
}
