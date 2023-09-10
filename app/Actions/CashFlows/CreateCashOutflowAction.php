<?php

declare(strict_types=1);

namespace App\Actions\CashFlows;

use App\Actions\CashFlows\Data\CreateCashFlowData;
use App\Actions\CashFlows\Data\CreateCashOutflowData;
use App\Actions\CashOutflowDetails\CreateDetailsAction;
use App\Actions\CashOutflowDetails\Data\DetailsData;
use App\Models\CashFlow;
use Illuminate\Support\Facades\DB;

class CreateCashOutflowAction
{
    public function __construct(
        private readonly CreateCashFlowAction $createCashFlowAction,
        private readonly CreateDetailsAction $createDetailsAction,
    ) {
    }

    public function exec(CreateCashOutflowData $data): CashFlow
    {
        return DB::transaction(function () use ($data) {
            $cashFlow = $this->createCashFlowAction->exec(CreateCashFlowData::from($data));

            $data->details->each(fn (DetailsData $details) => $this->createDetailsAction->exec($cashFlow, $details));

            return $cashFlow;
        });
    }
}
