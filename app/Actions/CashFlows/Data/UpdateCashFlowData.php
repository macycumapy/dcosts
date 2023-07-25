<?php

declare(strict_types=1);

namespace App\Actions\CashFlows\Data;

use Carbon\Carbon;
use Spatie\LaravelData\Data;

class UpdateCashFlowData extends Data
{
    public Carbon $date;
    public float $sum;
    public ?int $cost_item_id;
    public ?int $partner_id;
}
