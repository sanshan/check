<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Position;
use Faker\Generator as Faker;

$factory->define(Position::class, function (Faker $faker) {
    return [
        'title' => $faker->text(100),
        'code' => $faker->text(10),
        'to_rate' =>$faker->boolean,
    ];
});
