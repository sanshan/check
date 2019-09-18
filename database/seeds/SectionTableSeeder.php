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
        factory(App\Section::class, 10)->create()->each(function($r){
            $r->questions()->saveMany(factory(App\Question::class, 40)->make());
        });

        $positions = App\Position::where('to_rate', 1)->get();

        App\Question::all()->each(function($r) use ($positions){
           $r->positions()->attach(
               $positions->random(rand(1,3))->pluck('id')->toArray()
           );
        });
    }
}
