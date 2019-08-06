<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 10)->create()->each(function($u) {
            $u->profile()->save(factory(App\Profile::class)->make());
        });

        App\Profile::each(function($p){
            $p->regions()->attach(App\Region::all()->random(2));
        });

        App\Profile::each(function($p){
            $p->stations()->attach(App\GasStation::whereIn('region_id', $p->regions->pluck('id')->toArray())->get()->random(8));
        });
    }
}
