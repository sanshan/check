<?php

namespace App\Http\Requests\TypeOfChecklist;

class TypeOfChecklistIndexRequest extends TypeOfChecklistRequest
{
    public function rules()
    {
        return [
            'title' => 'nullable|string|max:100',
        ];
    }
}
