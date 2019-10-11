<?php

namespace App\Http\Resources\Question;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionInfoResource extends JsonResource
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
            'title' => $this->title,
        ];
    }
}
