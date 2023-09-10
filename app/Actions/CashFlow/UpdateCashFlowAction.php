<?php

declare(strict_types=1);

namespace App\Actions\CashFlow;

use App\Actions\CashFlow\Data\UpdateCashFlowData;
use App\Models\CashFlow;

class UpdateCashFlowAction
{
    public function exec(CashFlow $cashFlow, UpdateCashFlowData $data): bool
    {
        return $cashFlow->update($data->toArray());
    }
}
