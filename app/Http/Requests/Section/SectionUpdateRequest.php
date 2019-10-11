<?php

namespace App\Http\Requests\Section;

class SectionUpdateRequest extends SectionRequest
{
    public function rules()
    {
        return [
                'section_id' => 'required|integer|exists:sections,id',
                'title'      => 'required|string|max:100|unique:sections,title,' . $this->section_id,
            ] + parent::rules();
    }
}
