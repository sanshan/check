<?php


namespace App\Traits;

use App\Classes\Filter\Facade\ListFilterFacade;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait FilterModels
{
    public function scopeFilter(Builder $builder, Request $request)
    {
        return ListFilterFacade::filter($builder, $request->validated());
    }
}
