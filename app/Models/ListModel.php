<?php

namespace App\Models;

use App\Classes\Filter\ListFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

abstract class ListModel extends Model
{
    use SoftDeletes;

    //Надо использовать trait
    public function scopeFilter(Builder $builder, Request $request): Builder
    {
        //Возможно, стоит в этом месте использовать фасад.
        return (new ListFilter($request->validated()))->filter($builder);
    }
}
