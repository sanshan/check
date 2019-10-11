<?php

namespace App\Http\Requests\Role;

use App\Http\Requests\ValidateRequest;

class RoleRequest extends ValidateRequest
{
    public function rules()
    {
        return [
            'title' => 'required|string|max:100|unique:roles,title',
        ];
    }
}
