<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
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
            'phone'         => $this->phone,
            'full_name'     => $this->full_name,
            'role'          => RoleResource::make($this->whenLoaded('role')),
            'stations'      => GasStationResource::collection($this->whenLoaded('stations')),
            'regions'       => RegionResource::collection($this->whenLoaded('regions')),
        ];
    }
}
