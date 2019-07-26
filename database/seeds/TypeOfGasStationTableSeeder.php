<?php

use Illuminate\Database\Seeder;

class TypeOfGasStationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\TypeOfGasStation::class, 10)->create();
    }
}
