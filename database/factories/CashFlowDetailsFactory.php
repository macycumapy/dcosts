<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Documents\CashFlowDetails;
use Faker\Generator as Faker;

$factory->define(CashFlowDetails::class, function (Faker $faker) {
    return [
        'nomenclature_id' => 1,
        'quantity' => rand(1,3),
        'cost' => $faker->randomFloat(),
    ];
});
