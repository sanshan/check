<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\TypeOfGasStation;
use Faker\Generator as Faker;

$factory->define(TypeOfGasStation::class, function (Faker $faker) {
    return [
        'title' => $faker->text(100),
        'abbreviation' => $faker->text(10),
    ];
});
