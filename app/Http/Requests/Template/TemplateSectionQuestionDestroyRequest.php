<?php

namespace App\Http\Requests\Template;

use Illuminate\Validation\Rule;

class TemplateSectionQuestionDestroyRequest extends TemplateRequest
{
    public function rules()
    {
        return [
            'section'     => Rule::in($this->route('template')->sections->pluck('id')->toArray()),
            'questions'   => 'required|array|min:1',
            'questions.*' => Rule::exists('question_section_template', 'question_id')
                ->where(
                    'section_template_id',
                    optional(
                        optional($this->route('template')
                            ->sections()
                            ->where(
                                'sections.id', $this->route('section')->id
                            )
                            ->first()
                        )->pivot
                    )->id
                ),
        ];
    }

    public function all($keys = null)
    {
        $data = parent::all($keys);
        $data['section'] = $this->route('section')->id;
        return $data;
    }
}
