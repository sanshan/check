<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Question;
use Faker\Generator as Faker;

$factory->define(Question::class, function (Faker $faker) {
    return [
        'title' => $faker->unique()->text(100),
        'required' => $faker->boolean,
        'partly' => $faker->boolean,
    ];
});
