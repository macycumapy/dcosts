<?php

declare(strict_types=1);

namespace App\Actions\CashFlows;

use App\Actions\CashFlows\Data\CreateCashFlowData;
use App\Models\CashFlow;

class CreateCashFlowAction
{
    public function exec(CreateCashFlowData $data): CashFlow
    {
        return CashFlow::create($data->toArray());
    }
}
