<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Profile\ProfileResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'id'        => $this->id,
            'email'     => $this->email,
            'profile'   => ProfileResource::make($this->whenLoaded('profile')),
        ];
    }
}
