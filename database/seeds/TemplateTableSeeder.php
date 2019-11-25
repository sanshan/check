<?php

use Illuminate\Database\Seeder;

class TemplateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Models\User::inRandomOrder()->take(20)->get()->each(function ($user) {
            $user->templates()->saveMany(
                factory(App\Models\Template::class, rand(2, 4))->make()
            );

            $user->templates->each(function ($template) use ($user) {
                $template->attachSections(
                    App\Models\Section::inRandomOrder()
                        ->take(rand(1, 10))
                        ->pluck('id')
                        ->toArray()
                );
                $template->regions()->attach(
                    App\Models\Region::whereIn(
                        'id',
                        $user->profile->regions
                            ->pluck('id')
                            ->toArray()
                    )
                        ->take(rand(1, $user->profile->regions()->count()))
                        ->pluck('id')
                        ->toArray()
                );
                $template->gasStationTypes()->attach(
                    App\Models\TypeOfGasStation::inRandomOrder()
                        ->take(rand(1, 3))
                        ->pluck('id')
                        ->toArray()
                );
            });
        });
    }
}
