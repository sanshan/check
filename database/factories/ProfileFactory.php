<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Profile;
use Faker\Generator as Faker;

$factory->define(Profile::class, function (Faker $faker) {
    return [
        'name' => $faker->firstName,
        'patronymic' => $faker->title,
        'surname' => $faker->lastName,
        'phone' => $faker->phoneNumber,
        'role_id' => App\Role::inRandomOrder()->first()->id,
    ];
});
