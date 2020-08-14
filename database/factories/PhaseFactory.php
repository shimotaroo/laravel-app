<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Phase;
use Faker\Generator as Faker;

$factory->define(Phase::class, function (Faker $faker) {
    return [
        'phase' => $faker->name,
    ];
});
