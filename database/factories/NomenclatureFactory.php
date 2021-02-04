<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Dictionaries\Nomenclature;
use Faker\Generator as Faker;

$factory->define(Nomenclature::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'nomenclature_type_id' => factory(\App\Models\Dictionaries\NomenclatureType::class)->create()->id,
        'user_id' => auth()->id(),
    ];
});
