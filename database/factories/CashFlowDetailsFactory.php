<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Documents\CashFlowDetails;
use Faker\Generator as Faker;

$factory->define(CashFlowDetails::class, function (Faker $faker) {
    return [
        'nomenclature_id' => factory(\App\Models\Dictionaries\Nomenclature::class)->create()->id,
        'quantity' => rand(1,3),
        'cost' => $faker->randomFloat(),
    ];
});
