<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Documents\CashFlow;
use Faker\Generator as Faker;

$factory->define(CashFlow::class, function (Faker $faker) {
    return [
        'incoming' => $faker->boolean,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
    ];
});
