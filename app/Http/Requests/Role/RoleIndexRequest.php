<?php

namespace App\Http\Requests\Role;

class RoleIndexRequest extends RoleRequest
{
    public function rules()
    {
        return [
            'title' => 'nullable|string|max:10',
        ];
    }
}
