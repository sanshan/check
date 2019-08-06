<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call([
             TypeOfGasStationTableSeeder::class,
             TypeOfChecklistTableSeeder::class,
             RoleTableSeeder::class,
             RegionTableSeeder::class,
             UserTableSeeder::class,
             PositionTableSeeder::class,
         ]);
    }
}
