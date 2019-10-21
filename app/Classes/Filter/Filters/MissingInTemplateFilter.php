<?php


namespace App\Classes\Filter\Filters;


class MissingInTemplateFilter
{
    public function filter($builder, $value)
    {
        $builder->doesntHave('templates')
            ->orWhereHas('templates', function ($query) use ($value) {
                $query->where('templates.id', '!=', $value);
            });
    }
}
