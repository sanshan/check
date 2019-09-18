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
        factory(App\Template::class, 10)->create()->each(function($r){
            $questions_id = App\Question::inRandomOrder()->take(20)->pluck('id')->toArray();
            $gasStationType = App\TypeOfGasStation::inRandomOrder()->take(3)->get();
            $r->questions()->sync($questions_id);
            $r->gasStationTypes()->sync($gasStationType);
        });
    }
}
