<?php


namespace App\Classes\Filter\Filters;


class PresentInTemplate
{
    public function filter($builder, $value)
    {
        $builder->WhereHas('templates', function ($query) use ($value) {
                $query->where('templates.id', $value);
            });
    }
}
