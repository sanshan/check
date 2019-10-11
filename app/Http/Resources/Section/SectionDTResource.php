<?php

namespace App\Http\Resources\Section;

use Illuminate\Http\Resources\Json\JsonResource;

class SectionDTResource extends JsonResource
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
            'id'                => $this->id,
            'title'             => $this->title,
            'questions_count'   => $this->questions_count,
        ];
    }
}
