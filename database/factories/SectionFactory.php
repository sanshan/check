<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Section;
use Faker\Generator as Faker;

$factory->define(Section::class, function (Faker $faker) {
    return [
        'title' => $faker->text(100),
    ];
});
