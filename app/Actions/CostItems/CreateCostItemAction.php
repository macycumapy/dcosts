<?php

declare(strict_types=1);

namespace App\Actions\CostItems;

use App\Actions\CostItems\Data\CreateCostItemData;
use App\Models\CostItem;

class CreateCostItemAction
{
    public function exec(CreateCostItemData $data): CostItem
    {
        return CostItem::create($data->toArray());
    }
}
