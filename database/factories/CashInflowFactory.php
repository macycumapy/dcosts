<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Documents\CashInflow;
use Faker\Generator as Faker;

$factory->define(CashInflow::class, function (Faker $faker) {
    return [
        'date' => $faker->dateTime,
        'sum' => $faker->randomFloat(2,0,10000),
        'cost_item_id' => factory(\App\Models\Dictionaries\CostItem::class)->create()->id,
        'partner_id' => factory(\App\Models\Dictionaries\Partner::class)->create()->id,
        'user_id' => auth()->id(),
    ];
});
