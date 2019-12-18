<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Dictionaries\Partner;
use Faker\Generator as Faker;

$factory->define(Partner::class, function (Faker $faker) {
    return [
        'name' => $faker->name
    ];
});
