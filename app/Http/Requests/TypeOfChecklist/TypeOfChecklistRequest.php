<?php

namespace App\Http\Requests\TypeOfChecklist;

use App\Http\Requests\ValidateRequest;

class TypeOfChecklistRequest extends ValidateRequest
{
    public function rules()
    {
        return [
            'title' => 'required|string|max:100|unique:type_of_checklists,title',
        ];
    }
}
