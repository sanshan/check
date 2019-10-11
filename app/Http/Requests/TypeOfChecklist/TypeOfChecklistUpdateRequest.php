<?php

namespace App\Http\Requests\TypeOfChecklist;

class TypeOfChecklistUpdateRequest extends TypeOfChecklistRequest
{
    public function rules()
    {
        return [
                'type_of_checklist_id' => 'required|integer|exists:type_of_checklists,id',
                'title'                => 'required|string|max:100|unique:type_of_checklists,title,' . $this->type_of_checklist_id,
            ] + parent::rules();
    }
}
