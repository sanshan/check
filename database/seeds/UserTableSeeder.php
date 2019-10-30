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
        factory(App\Models\User::class, 60)->create()->each(function($u) {
            $u->profile()->save(factory(App\Models\Profile::class)->make());
        });

        App\Models\Profile::each(function($p){
            $p->regions()->attach(App\Models\Region::all()->random(2));
        });

        App\Models\Profile::each(function($p){
            $p->stations()->attach(App\Models\GasStation::whereIn('region_id', $p->regions->pluck('id')->toArray())->get()->random(8));
        });
    }
}
