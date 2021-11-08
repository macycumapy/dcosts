<?php

namespace Database\Factories;

use App\Models\CostItem;
use App\Models\Partner;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CashInflowFactory extends Factory
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
            'sum' => 500,
            'cost_item_id' => CostItem::factory()->create(),
            'partner_id' => Partner::factory()->create(),
            'user_id' => User::factory()->create(),
        ];
    }
}
