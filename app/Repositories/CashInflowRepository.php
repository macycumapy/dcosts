<?php

namespace App\Repositories;

use App\Enums\CashFlowType;
use App\Models\CashFlow;
use Illuminate\Database\Eloquent\Model;

class CashInflowRepository extends CashFlowRepository
{
    /**
     * @param CashFlow $model
     */
    public function __construct(CashFlow $model)
    {
        parent::__construct($model);
        $this->query->ofInflows();
    }

    /**
     * @inheritDoc
     */
    public function create(array $data): Model
    {
        $data = array_merge($data, ['type' => CashFlowType::Inflow]);
        return parent::create($data);
    }
}