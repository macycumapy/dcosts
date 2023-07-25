<?php

declare(strict_types=1);

namespace App\Actions\CashFlows;

use App\Actions\CashFlows\Data\UpdateCashFlowData;
use App\Models\CashFlow;

class UpdateCashFlowAction
{
    public function exec(CashFlow $cashFlow, UpdateCashFlowData $data): bool
    {
        return $cashFlow->update($data->toArray());
    }
}
