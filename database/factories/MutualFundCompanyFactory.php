<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\MutualFundCompany;
use Faker\Generator as Faker;

$factory->define(MutualFundCompany::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'status' => 1,
    ];
});
