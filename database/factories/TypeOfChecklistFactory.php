<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\TypeOfChecklist;
use Faker\Generator as Faker;

$factory->define(TypeOfChecklist::class, function (Faker $faker) {
    return [
        'title' => $faker->text(100),
    ];
});
