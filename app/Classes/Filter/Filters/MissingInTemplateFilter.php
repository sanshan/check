<?php


namespace App\Classes\Filter\Filters;


class MissingInTemplateFilter
{
    public function filter($builder, $value)
    {
        $builder->whereHas('templates', function ($query) use ($value) {
            $query->where('templates.id', '!=', $value);
        });
    }
}
