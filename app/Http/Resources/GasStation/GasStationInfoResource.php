<?php

namespace App\Http\Resources\GasStation;

use Illuminate\Http\Resources\Json\JsonResource;

class GasStationInfoResource extends JsonResource
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
            'number'            => $this->number,
            'address'           => $this->address,
            'phone'             => $this->phone,
            'email'             => $this->email,
        ];
    }
}
