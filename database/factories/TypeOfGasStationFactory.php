<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\TypeOfGasStation;
use Faker\Generator as Faker;

$factory->define(TypeOfGasStation::class, function (Faker $faker) {
    return [
        'title' => str_replace('.', '', $faker->unique()->text(20)),
        'abbreviation' => str_replace('.', '', $faker->unique()->text(5)),
    ];
});
