<?php

namespace Database\Factories;

use App\Models\CostItem;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CashOutflowFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'date' => now(),
            'cost_item_id' => CostItem::factory()->create(),
            'user_id' => User::factory()->create(),
        ];
    }
}
