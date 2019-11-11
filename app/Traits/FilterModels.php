<?php


namespace App\Traits;

use App\Classes\Filter\Facade\ListFilterFacade;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait FilterModels
{
    public function scopeFilter(Builder $builder, Request $request)
    {
        \Log::info($request->validated());
        return ListFilterFacade::filter($builder, $request->validated());
    }
}
