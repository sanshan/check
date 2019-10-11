<?php

namespace App\Http\Resources\GasStation;

use App\Http\Resources\Region\RegionResource;
use App\Http\Resources\TypeOfGasStation\TypeOfGasStationResource;
use Illuminate\Http\Resources\Json\JsonResource;

class GasStationDTResource extends JsonResource
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
            'id'                => $this->id,
            'number'            => $this->number,
            'region'            => RegionResource::make($this->whenLoaded('region')),
            'type'              => TypeOfGasStationResource::make($this->whenLoaded('type')),
            'address'           => $this->address,
            'is_shop'           => $this->is_shop,
            'it_works'          => $this->it_works,
            'full_name'         => $this->full_name,
            'phone'             => $this->phone,
            'email'             => $this->email,
        ];
    }
}
