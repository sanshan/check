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
        factory(App\Models\Region::class, 30)->create()->each(function($r) {
            $r->stations()->saveMany(factory(App\Models\GasStation::class, 10)->make());
        });
    }
}
