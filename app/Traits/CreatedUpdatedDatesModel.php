<?php

namespace App\Traits;

trait CreatedUpdatedDatesModel
{
    public function getCreatedDateAttribute() {
        return \Carbon\Carbon::parse($this->created_at)->format('d.m.Y H:i:s');
    }

    public function getUpdatedDateAttribute() {
        return \Carbon\Carbon::parse($this->created_at)->format('d.m.Y H:i:s');
    }
}
