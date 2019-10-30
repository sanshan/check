<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Position;
use Faker\Generator as Faker;

$factory->define(Position::class, function (Faker $faker) {
    return [
        'title' => str_replace('.', '', $faker->text(20)),
        'code' => str_replace('.', '', $faker->text(5)),
        'to_rate' =>$faker->boolean,
    ];
});
