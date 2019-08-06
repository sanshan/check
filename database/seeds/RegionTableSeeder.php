<?php

use Illuminate\Database\Seeder;

class RegionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Region::class, 10)->create()->each(function($r) {
            $r->stations()->saveMany(factory(App\GasStation::class, 10)->make());
        });
    }
}
