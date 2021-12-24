<?php

namespace Database\Factories;

use App\Enums\CashFlowType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CostItemFactory extends Factory
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
            'type' => CashFlowType::Inflow,
        ];
    }

    public function outflow()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => CashFlowType::Outflow,
            ];
        });
    }
}
