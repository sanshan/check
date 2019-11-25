<?php

namespace App\Providers;

use App\Models\Template;
use App\Models\TemplateSectionPivot;
use App\Observers\TemplateObserver;
use App\Observers\TemplateSectionObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(\Faker\Generator::class, function () {
            return \Faker\Factory::create('ru_RU');
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Template::observe(TemplateObserver::class);
        TemplateSectionPivot::observe(TemplateSectionObserver::class);
    }
}
