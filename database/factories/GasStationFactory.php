<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\GasStation;
use Faker\Generator as Faker;

$factory->define(GasStation::class, function (Faker $faker) {
    return [
        'region_id' => App\Region::inRandomOrder()->first()->id,
        'type_of_gas_station_id' => App\TypeOfGasStation::inRandomOrder()->first()->id,
        'number' => $faker->text(5),
        'address' => $faker->address,
        'is_shop' => $faker->boolean,
        'it_works' => $faker->boolean,
        'dir_name' => $faker->firstName,
        'dir_patronymic' => $faker->title,
        'dir_surname' => $faker->lastName,
        'email' => $faker->email,
        'phone' => $faker->phoneNumber,
    ];
});
