<?php

namespace App\Repositories;

use App\Models\CashInflow;
use Illuminate\Pagination\LengthAwarePaginator;

class CashInflowRepository extends AbstractRepository
{
    /**
     * @param CashInflow $model
     */
    public function __construct(CashInflow $model)
    {
        parent::__construct($model);
    }

    /**
     * @inheritDoc
     */
    public function paginate(?array $filters = null): LengthAwarePaginator
    {
        $this->query->orderByDesc('date');

        return parent::paginate($filters);
    }
}