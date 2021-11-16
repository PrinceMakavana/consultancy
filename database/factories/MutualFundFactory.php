<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\MutualFund;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;

$factory->define(MutualFund::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'company_id' => random_int(DB::table('mutual_fund_company')->min('id'), DB::table('mutual_fund_company')->max('id')),
        'type_id' => random_int(DB::table('mutual_fund_type')->min('id'), DB::table('mutual_fund_type')->max('id')),
        'status' => 1,
    ];
});
