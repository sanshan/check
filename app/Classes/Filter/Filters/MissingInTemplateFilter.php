<?php


namespace App\Classes\Filter\Filters;


class MissingInTemplateFilter
{
    public function filter($builder, $value)
    {
        $builder->doesntHave('templates')
            ->orWhereDoesntHave('templates', function ($query) use ($value) {
                $query->where('templates.id', $value);
            });
    }
}
