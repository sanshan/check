<?php

namespace App\Http\Requests\Section;

use App\Http\Requests\ValidateRequest;

class SectionRequest extends ValidateRequest
{
    public function rules()
    {
        return [
            'title' => 'required|string|max:100|unique:sections,title',
        ];
    }
}
