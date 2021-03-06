<?php

namespace App\Classes\Filter\Filters;

class UserRegionFilter
{
    public function filter($builder, $value)
    {
        $builder->whereHas('profile.regions', function ($query) use ($value) {
            $query->where('regions.id', $value);
        });
    }
}
