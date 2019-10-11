<?php

namespace App\Http\Resources\Question;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionSelect2Resource extends JsonResource
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
