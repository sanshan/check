<?php

namespace App\Classes\Filter\Filters;

class NumberFilter
{
    public function filter($builder, $value)
    {
        $builder->where('number', 'LIKE', "%$value%");
    }
}
