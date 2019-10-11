<?php

namespace App\Classes\Filter\Filters;

class SectionFilter
{
    public function filter($builder, $value)
    {
        $builder->where('section_id', $value);
    }
}
