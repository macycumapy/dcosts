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

    public function firstOrCreate(string $name, CashFlowType $type = CashFlowType::Inflow): CostItem
    {
        return $this->query->firstOrCreate([
            'name' => Str::ucfirst($name),
            'type' => $type,
            'user_id' => Auth::id(),
        ], [
            'name' => Str::ucfirst($name),
            'type' => $type,
            'user_id' => Auth::id(),
        ]);
    }
}
