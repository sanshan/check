<?php

namespace App\Http\Resources\Question;

use App\Http\Resources\Position\PositionResource;
use App\Http\Resources\Section\SectionResource;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $positions          = $this->whenLoaded('positions');
        $pivot_positions    = optional($this->pivot)->positions ?? $positions;
        $edited             = $positions->toArray() !== $pivot_positions->toArray();

        return [
            'id'                        => $this->id,
            'title'                     => $this->title,
            'section'                   => SectionResource::make($this->whenLoaded('section')),
            'positions'                 => $edited ? PositionResource::collection($pivot_positions) : PositionResource::collection($positions),
            'edited'                    => $edited,
            'required'                  => $this->required,
            'partly'                    => $this->partly,
        ];
    }
}
