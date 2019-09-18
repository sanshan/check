<?php

namespace App\Http\Requests\Template;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TemplateQuestionsRequest extends FormRequest
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

        switch ($this->getMethod())
        {
            case 'PATCH':
                return [
                    'template_id' => 'required|integer|exists:templates,id',
                    'question_id' => [
                        'required',
                        'array',
                        'min:1',
                    ],
                    'question_id.*' => [
                        'exists:questions,id',
                        Rule::unique('question_template', 'question_id')->where('template_id', $this->template_id),
                    ],
                ];
            case 'PUT':
                return [
                        'template_id' => 'required|integer|exists:templates,id',
                        'question_id' => 'required|array|min:1',
                        'question_id.*' => [
                            Rule::exists('question_template', 'question_id')->where('template_id', $this->template_id),
                        ],
                    ];
            //case 'DELETE':
        }
    }
}
