<?php

namespace App\Http\Requests\Template;

use Illuminate\Validation\Rule;

class TemplateSectionQuestionPositionSyncRequest extends TemplateRequest
{
    public function rules()
    {
        return [
            'section'     => Rule::in($this->route('template')->sections->pluck('id')->toArray()),
            'question'    => Rule::in(
                optional(
                    optional(
                        optional(
                            optional($this->route('template')->sections()
                                ->where('sections.id', $this->route('section')->id)
                                ->first()
                            )->pivot
                        )->questions
                    )->pluck('id')
                )->toArray()
            ),
            'positions'   => 'required|array|min:1',
            'positions.*' => 'exists:positions,id',
        ];
    }

    public function all($keys = null)
    {
        $data = parent::all($keys);
        $data['section'] = $this->route('section')->id;
        $data['question'] = $this->route('question')->id;
        return $data;
    }
}
