<?php

namespace App\Repositories;

use App\Enums\CashFlowType;
use App\Models\CashFlow;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

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
