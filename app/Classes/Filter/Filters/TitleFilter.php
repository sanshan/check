<?php

namespace App\Classes\Filter\Filters;

class TitleFilter
{
    public function filter($builder, $value)
    {
        $builder->where('title', 'LIKE', "%$value%");
    }
}
