<?php

namespace Database\Factories;

use App\Models\NomenclatureType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class NomenclatureFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'user_id' => User::factory()->create(),
            'nomenclature_type_id' => NomenclatureType::factory()->create(),
        ];
    }
}
