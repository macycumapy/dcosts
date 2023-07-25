<?php

declare(strict_types=1);

namespace App\Actions\CashFlows\Data;

use App\Enums\CashFlowType;
use Carbon\Carbon;
use Spatie\LaravelData\Data;

class CreateCashFlowData extends Data
{
    public Carbon $date;
    public float $sum;
    public int $user_id;
    public CashFlowType $type;
    public ?int $cost_item_id;
    public ?int $partner_id;
}
