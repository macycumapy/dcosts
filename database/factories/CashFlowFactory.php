<?php

namespace Database\Factories;

use App\Enums\CashFlowType;
use App\Models\CostItem;
use App\Models\Partner;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CashFlowFactory extends Factory
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
            'type' => CashFlowType::Inflow,
        ];
    }
    
    public function outflow()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => CashFlowType::Outflow,
                'cost_item_id' => CostItem::factory()->outflow()->create(),
            ];
        });
    }
}
