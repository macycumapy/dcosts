<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Documents\CashFlow;
use Faker\Generator as Faker;

$factory->define(CashFlow::class, function (Faker $faker) {
    return [
        'cost_item_id' => null,
        'date' => $faker->dateTime,
        'sum' => $faker->randomFloat(2,0,1000),
    ];
});
