<?php

namespace App\Http\Resources\Template;

use App\Http\Resources\Position\PositionResource;
use Illuminate\Http\Resources\Json\JsonResource;

class TemplateSectionQuestionDTIndexResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'        => $this->id,
            'title'     => $this->title,
            //'positions' => PositionResource::make($this->whenLoaded('positions')),
            'positions' => optional($this->pivot)->positions,
            'rel' => optional($this->pivot)->id,
        ];
    }
}
