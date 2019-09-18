<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
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
            'id'=>$this->id,
            'start_date'=>$this->start_date->format('d.m.Y'),
            'end_date'=>$this->end_date->format('d.m.Y'),
            'region'=>RegionResource::make($this->whenLoaded('region')),
            'station'=>GasStationResource::make($this->whenLoaded('station')),
            'type'=>TypeOfChecklistResource::make($this->whenLoaded('type')),
            'user'=>UserResource::make($this->whenLoaded('user')),
        ];
    }
}
