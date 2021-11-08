<?php

namespace App\Repositories;

use App\Models\CashInflow;

class CashInflowRepository extends AbstractRepository
{
    /**
     * @param CashInflow $model
     */
    public function __construct(CashInflow $model)
    {
        parent::__construct($model);
    }
}