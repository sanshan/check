<?php

use Illuminate\Database\Seeder;

class SectionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Section::class, 10)->create()->each(function($r){
            $r->questions()->saveMany(factory(App\Models\Question::class, 40)->make());
        });

        App\Models\Question::all()->each(function($r){
           $r->positions()->attach(
               App\Models\Position::where('to_rate', 1)->get()->random(rand(1,3))->pluck('id')->toArray()
           );
        });
    }
}
