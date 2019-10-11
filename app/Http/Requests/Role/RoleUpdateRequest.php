<?php

namespace App\Http\Requests\Role;

class RoleUpdateRequest extends RoleRequest
{
    public function rules()
    {
        return [
                'role_id' => 'required|integer|exists:roles,id',
                'title'   => 'required|string|max:100|unique:roles,title,' . $this->role_id,
            ] + parent::rules();
    }
}
