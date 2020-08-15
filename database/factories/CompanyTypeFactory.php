<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\CompanyType;
use Faker\Generator as Faker;

$factory->define(CompanyType::class, function (Faker $faker) {
    return [
        'company_type' => $faker->name,
    ];
});
