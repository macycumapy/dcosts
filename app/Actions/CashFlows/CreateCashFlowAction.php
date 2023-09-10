<?php

declare(strict_types=1);

namespace App\Actions\CashFlows;

use App\Actions\CashFlows\Data\CreateCashFlowData;
use App\Models\CashFlow;

class CreateCashFlowAction
{
    public function exec(CreateCashFlowData $data): CashFlow
    {
        $cashFlow = new CashFlow($data->toArray());
        $cashFlow->user()->associate($data->user_id);
        $cashFlow->save();

        return $cashFlow;
    }
}
