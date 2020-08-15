<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Prefecture;
use Faker\Generator as Faker;

$factory->define(Prefecture::class, function (Faker $faker) {
    return [
        'prefecture' => $faker->name,
    ];
});
