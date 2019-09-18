<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Template;
use Faker\Generator as Faker;

$factory->define(Template::class, function (Faker $faker) {
    return [
        'author_id' => App\User::inRandomOrder()->first()->id,
        'type_of_checklist_id' => App\TypeOfChecklist::inRandomOrder()->first()->id,
        'status' => $faker->boolean,
    ];
});
