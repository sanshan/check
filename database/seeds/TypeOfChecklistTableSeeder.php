<?php

use Illuminate\Database\Seeder;

class TypeOfChecklistTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\TypeOfChecklist::class, 10)->create();
    }
}
