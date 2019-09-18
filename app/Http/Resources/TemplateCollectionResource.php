<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TemplateCollectionResource extends JsonResource
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
            'author'                => UserResource::make($this->whenLoaded('author')),
            'created_at'            => $this->created_at,
            'editor'                => UserResource::make($this->whenLoaded('editor')),
            'updated_at'            => $this->updated_at,
        ];
    }
}
