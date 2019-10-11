<?php

namespace App\Classes\Filter\Filters;

class UserRegionFilter
{
    public function filter($builder, $value)
    {
        $builder->whereHas('profile', function ($query) use ($value) {
            return $query->where('full_name', 'LIKE', "%$value%");
        });
    }
}
