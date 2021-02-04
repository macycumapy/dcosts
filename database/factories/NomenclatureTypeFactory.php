<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Dictionaries\NomenclatureType;
use Faker\Generator as Faker;

$factory->define(NomenclatureType::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'user_id' => auth()->id(),
    ];
});
