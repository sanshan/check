<?php

namespace App\Http\Resources\TypeOfGasStation;

use Illuminate\Http\Resources\Json\JsonResource;

class TypeOfGasStationInfoResource extends JsonResource
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
            'title' => $this->title,
        ];
    }
}
