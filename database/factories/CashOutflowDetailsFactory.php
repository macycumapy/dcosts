<?php

namespace Database\Factories;

use App\Models\Nomenclature;
use Illuminate\Database\Eloquent\Factories\Factory;

class CashOutflowDetailsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'count' => 5,
            'cost' => 100.0,
            'nomenclature_id' => Nomenclature::factory()->create(),
        ];
    }
}
