<?php

namespace App\Classes\Filter\Filters;

class TemplateIdFilter
{
    public function filter($builder, $value)
    {
        $builder->where('templates.id', $value);
    }
}
