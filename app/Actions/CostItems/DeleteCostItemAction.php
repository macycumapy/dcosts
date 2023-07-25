<?php

declare(strict_types=1);

namespace App\Actions\CostItems;

use App\Models\CostItem;

class DeleteCostItemAction
{
    public function exec(CostItem $costItem): bool
    {
        return $costItem->delete();
    }
}
