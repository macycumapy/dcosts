<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Enums\CashFlowType;
use App\Models\CostItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CostItemRepository extends AbstractRepository
{
    /**
     * @param CostItem $model
     */
    public function __construct(CostItem $model)
    {
        parent::__construct($model);
    }

    public function firstOrCreate(string $name): CostItem
    {
        return $this->query->firstOrCreate([
            'name' => Str::ucfirst($name),
            'type' => CashFlowType::Inflow,
            'user_id' => Auth::id(),
        ], [
            'name' => Str::ucfirst($name),
            'type' => CashFlowType::Inflow,
            'user_id' => Auth::id(),
        ]);
    }
}
