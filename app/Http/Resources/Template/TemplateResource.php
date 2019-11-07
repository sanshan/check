<?php

namespace App\Http\Resources\Template;

use App\Http\Resources\Question\QuestionResource;
use App\Http\Resources\Region\RegionResource;
use App\Http\Resources\Section\SectionResource;
use App\Http\Resources\TypeOfChecklist\TypeOfChecklistResource;
use App\Http\Resources\TypeOfGasStation\TypeOfGasStationResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class TemplateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                  => $this->id,
            'title'               => $this->title,
            'type_of_gas_station' => TypeOfGasStationResource::collection($this->whenLoaded('gasStationTypes')),
            'type_of_checklist'   => TypeOfChecklistResource::make($this->whenLoaded('templateTypes')),
            'regions'             => RegionResource::collection($this->whenLoaded('regions')),
            'sections'            => SectionResource::collection($this->whenLoaded('sections')),
            'status'              => $this->status,
            'user'                => UserResource::make($this->whenLoaded('user')),
            'created_at'          => $this->created_date,
            'editor'              => UserResource::make($this->whenLoaded('editor')),
            'updated_at'          => $this->updated_date,
        ];
    }
}
