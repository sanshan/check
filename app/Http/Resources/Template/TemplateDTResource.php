<?php

namespace App\Http\Resources\Template;

use App\Http\Resources\Question\QuestionResource;
use App\Http\Resources\Region\RegionResource;
use App\Http\Resources\TypeOfChecklist\TypeOfChecklistResource;
use App\Http\Resources\TypeOfGasStation\TypeOfGasStationResource;
use Illuminate\Http\Resources\Json\JsonResource;

class TemplateDTResource extends JsonResource
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
            'id'                    => $this->id,
            'title'                 => $this->title,
            'type_of_gas_station'   => TypeOfGasStationResource::make($this->whenLoaded('gasStationTypes')),
            'type_of_checklist'     => TypeOfChecklistResource::make($this->whenLoaded('templateTypes')),
            'regions'               => RegionResource::make($this->whenLoaded('regions')),
            'questions'             => QuestionResource::make($this->whenLoaded('questions')),
            'questions_count'       => $this->questions_count,
            'status'                => $this->status,
        ];
    }
}
