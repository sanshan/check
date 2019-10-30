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
                $template->sections()->attach(
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

        /*App\Models\User::inRandomOrder()->take(20)->get()->each(function ($user) {
            $user->templates()->createMany(factory(App\Models\Template::class, rand(2, 3))->make())
                ->each(function ($template) {
                    $template->sections()->sync(App\Models\Section::inRandomOrder()->take(rand(1, 10))->get());
                    $template->gasStationTypes()->sync(App\Models\TypeOfGasStation::inRandomOrder()->take(rand(1, 3))->get());
                });
        });*/

        /*factory(App\Models\Template::class, 10)->create()->each(function($r){
            $sections = App\Models\Section::inRandomOrder()->take(rand(1,10))->get();
            $gasStationTypes = App\Models\TypeOfGasStation::inRandomOrder()->take(rand(1,3))->get();
            $r->sections()->sync($sections);
            $r->gasStationTypes()->sync($gasStationTypes);
        });*/
    }
}
