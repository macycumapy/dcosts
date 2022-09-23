<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\CashFlow;
use Illuminate\Pagination\LengthAwarePaginator;

class CashFlowRepository extends AbstractRepository
{
    /**
     * @param CashFlow $model
     */
    public function __construct(CashFlow $model)
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
