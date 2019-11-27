<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\NomenclatureType;
use Faker\Generator as Faker;

$factory->define(NomenclatureType::class, function (Faker $faker) {
    return [
        'name' => $faker->name
    ];
});
