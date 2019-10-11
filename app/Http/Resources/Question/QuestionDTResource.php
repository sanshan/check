<?php

namespace App\Http\Resources\Question;

use App\Http\Resources\Position\PositionResource;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionDTResource extends JsonResource
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
            'id'                        => $this->id,
            'title'                     => $this->title,
            'positions'                 => PositionResource::make($this->whenLoaded('positions')),
            'required'                  => $this->required,
            'partly'                    => $this->partly,
        ];
    }
}
