<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\MutualFundType;
use Faker\Generator as Faker;

$factory->define(MutualFundType::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'status' => 1,
    ];
});
