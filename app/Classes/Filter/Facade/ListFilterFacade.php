<?php


namespace App\Classes\Filter\Facade;

use Illuminate\Support\Facades\Facade;

class ListFilterFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'App\Classes\Filter\ListFilter';
    }
}
