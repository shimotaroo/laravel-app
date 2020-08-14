<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Article;
use App\CompanyType;
use App\Phase;
use App\Prefecture;
use App\User;
use Faker\Generator as Faker;

$factory->define(Article::class, function (Faker $faker) {
    return [
        'user_id' => function() {
            return factory(User::class);
        },
        'prefecture_id' => function() {
            return factory(Prefecture::class);
        },
        'company_type_id' => function() {
            return factory(CompanyType::class);
        },
        'phase_id' => function() {
            return factory(Phase::class);
        },
        'question_content' => $faker->text(1000),
        'other_information' => $faker->text(1000),
        'impression' => $faker->text(1000),
    ];
});
