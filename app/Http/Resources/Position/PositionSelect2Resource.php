<?php

namespace App\Http\Resources\Position;

use Illuminate\Http\Resources\Json\JsonResource;

class PositionSelect2Resource extends JsonResource
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
            'id'            => $this->id,
            'title'         => $this->title,
        ];
    }
}
