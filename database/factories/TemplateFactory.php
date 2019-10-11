<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Template;
use Faker\Generator as Faker;

$factory->define(Template::class, function (Faker $faker) {
    return [
        'author_id' => App\Models\User::inRandomOrder()->first()->id,
        'type_of_checklist_id' => App\Models\TypeOfChecklist::inRandomOrder()->first()->id,
        'status' => $faker->boolean,
    ];
});
