<?php

namespace App\Http\Requests\Region;

class RegionIndexRequest extends RegionRequest
{
    public function rules()
    {
        return [
            'title' => 'nullable|string|max:10'
        ];
    }
}
