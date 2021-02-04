<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Documents\CashFlow;
use Faker\Generator as Faker;

$factory->define(CashFlow::class, function (Faker $faker) {
    return [
        'date' => $faker->dateTime,
        'sum' => $faker->randomFloat(2,0,1000),
        'user_id' => auth()->id(),
        'cost_item_id' => factory(\App\Models\Dictionaries\CostItem::class)->create()->id,
    ];
});
