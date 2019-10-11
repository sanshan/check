<?php

namespace App\Http\Resources\Template;

use Illuminate\Http\Resources\Json\JsonResource;

class TemplateInfoResource extends JsonResource
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
