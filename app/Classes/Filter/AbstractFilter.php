<?php

namespace App\Classes\Filter;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class AbstractFilter
{
    protected $params;
    protected $filters = [];

    public function filter(Builder $builder, $params = [])
    {
        $this->params = $params;

        foreach ($this->getFilters() as $filter => $value) {
            $this->resolveFilter($filter)->filter($builder, $value);
        }
        return $builder;
    }

    protected function getFilters()
    {
        return array_intersect_key($this->params, $this->filters);
    }

    protected function resolveFilter($filter)
    {
        return new $this->filters[$filter];
    }
}
