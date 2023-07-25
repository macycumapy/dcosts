<?php

declare(strict_types=1);

namespace App\Builder;

use App\Enums\CashFlowType;
use Illuminate\Database\Eloquent\Builder;

class CashFlowBuilder extends Builder
{
    public function outflows(): Builder
    {
        return $this->where('type', CashFlowType::Outflow);
    }

    public function inflows(): Builder
    {
        return $this->where('type', CashFlowType::Inflow);
    }
}
