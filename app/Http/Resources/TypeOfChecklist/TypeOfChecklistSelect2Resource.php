<?php

namespace App\Http\Resources\TypeOfChecklist;

use Illuminate\Http\Resources\Json\JsonResource;

class TypeOfChecklistSelect2Resource extends JsonResource
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
            'id'        => $this->id,
            'title'     => $this->title,
        ];
    }
}
