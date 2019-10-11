<?php

namespace App\Classes\Filter\Filters;

class GasStationRegionFilter
{
    public function filter($builder, $value)
    {
        $builder->whereHas('region', function ($query) use ($value) {
            $query->where('regions.id', $value);
        });
    }
}
