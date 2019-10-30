<?php

namespace App\Http\Resources\Template;

use App\Http\Resources\Question\QuestionResource;
use App\Http\Resources\Region\RegionResource;
use App\Http\Resources\TypeOfChecklist\TypeOfChecklistResource;
use App\Http\Resources\TypeOfGasStation\TypeOfGasStationResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class TemplateResource extends JsonResource
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
            'type_of_gas_station'   => TypeOfGasStationResource::collection($this->whenLoaded('gasStationTypes')),
            'type_of_checklist'     => TypeOfChecklistResource::make($this->whenLoaded('templateTypes')),
            'regions'               => RegionResource::collection($this->whenLoaded('regions')),
            'questions'             => QuestionResource::collection($this->whenLoaded('questions')),
            'questions_count'       => $this->questions_count,
            'status'                => $this->status,
            'author'                => UserResource::make($this->whenLoaded('author')),
            'created_at'            => $this->created_date,
            'editor'                => UserResource::make($this->whenLoaded('editor')),
            'updated_at'            => $this->updated_date,
        ];
    }
}