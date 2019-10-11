<?php

namespace App\Http\Resources\Region;

use Illuminate\Http\Resources\Json\JsonResource;

class RegionInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'title'         => $this->title,
        ];
    }
}
