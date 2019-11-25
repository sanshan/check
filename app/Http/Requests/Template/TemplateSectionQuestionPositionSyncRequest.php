<?php

namespace App\Http\Requests\Template;

use Illuminate\Validation\Rule;

class TemplateSectionQuestionPositionSyncRequest extends TemplateRequest
{
    public function rules()
    {
        \Log::info('~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~');
        \Log::info($this->route('tsq'));
        return [
            'positions'   => 'required|array|min:1',
            'positions.*' => Rule::exists('questions', 'id'),
            'tsq'         => Rule::exists('question_section_template', 'id')->where('section_template_id', $this->route('ts')->id),
        ];
    }

    public function all($keys = null)
    {
        $data = parent::all($keys);
        $data['tsq'] = $this->route('tsq')->id;
        return $data;
    }
}
