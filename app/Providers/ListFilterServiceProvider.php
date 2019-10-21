<?php

namespace App\Providers;

use App\Classes\Filter\ListFilter;
use Illuminate\Support\ServiceProvider;

class ListFilterServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ListFilter::class, function ($app){
            return new ListFilter;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [ListFilter::class];
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
