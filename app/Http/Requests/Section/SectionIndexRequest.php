<?php

namespace App\Http\Requests\Section;

class SectionIndexRequest extends SectionRequest
{
    public function rules()
    {
        return [
            'title' => 'nullable|string|max:100',
        ];
    }
}
