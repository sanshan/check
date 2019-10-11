<?php

namespace App\Http\Resources\GasStation;

use App\Http\Resources\Region\RegionResource;
use App\Http\Resources\Region\RegionSelect2Resource;
use Illuminate\Http\Resources\Json\JsonResource;

class GasStationSelect2Resource extends JsonResource
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
            'id'            => $this->id,
            'number'        => $this->number,
            'region'     => RegionResource::make($this->whenLoaded('region')),
        ];
    }
}
