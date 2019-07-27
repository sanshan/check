<?php

use Illuminate\Database\Seeder;

class GasStationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\GasStation::class, 10)->create();
    }
}
