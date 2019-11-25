<?php

namespace App\Http\Requests\Template;

use Illuminate\Validation\Rule;

class TemplateSectionQuestionStoreRequest extends TemplateRequest
{
    public function rules()
    {
        \Log::info('ооо------------------------------------');
        \Log::info($this->route('ts'));
        \Log::info('ооо---------------------------------');

        return [
            'ts'          => Rule::exists('section_template', 'id')->where('template_id', $this->route('template')->id),
            'questions'   => 'required|array|min:1',
            'questions.*' => [
                'exists:questions,id',
                Rule::unique('question_section_template', 'question_id')
                    ->where(
                        'section_template_id', $this->ts
                    ),
                Rule::exists('questions', 'id')
                    ->where('section_id', $this->route('ts')->section_id)
            ],
        ];
    }

    public function all($keys = null)
    {
        $data = parent::all($keys);
        $data['ts'] = $this->route('ts')->id;
        return $data;
    }
}
