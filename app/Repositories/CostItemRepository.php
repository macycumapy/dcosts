<?php

namespace App\Repositories;

use App\Models\CostItem;

class CostItemRepository extends AbstractRepository
{
    /**
     * @param CostItem $model
     */
    public function __construct(CostItem $model)
    {
        parent::__construct($model);
    }
}