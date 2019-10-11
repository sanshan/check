<?php

namespace App\Http\Requests\Region;

class RegionUpdateRequest extends RegionRequest
{
    public function rules()
    {
        return [
                'region_id' => 'required|integer|exists:regions,id',
                'title'     => 'required|string|max:100|unique:regions,title,' . $this->region_id,
            ] + parent::rules();
    }
}
