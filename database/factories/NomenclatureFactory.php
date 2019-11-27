<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Nomenclature;
use Faker\Generator as Faker;

$factory->define(Nomenclature::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'nomenclature_type_id' => 1
    ];
});
