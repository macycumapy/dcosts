<?php

declare(strict_types=1);

namespace App\Actions\CostItems;

use App\Actions\CostItems\Data\UpdateCostItemData;
use App\Models\CostItem;

class UpdateCostItemAction
{
    public function exec(CostItem $costItem, UpdateCostItemData $data): bool
    {
        return $costItem->update($data->toArray());
    }
}
