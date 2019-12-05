<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\CostItem;
use Faker\Generator as Faker;

$factory->define(CostItem::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
    ];
});
