<?php

declare(strict_types=1);

namespace App\Actions\CashFlow\Data;

use App\Actions\CashOutflowDetail\Data\DetailsData;
use App\Enums\CashFlowType;
use Carbon\Carbon;
use Spatie\LaravelData\Attributes\Computed;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class CreateCashOutflowData extends Data
{
    #[Computed]
    public readonly float $sum;
    public readonly CashFlowType $type;

    public function __construct(
        public Carbon          $date,
        public int             $user_id,
        public ?int            $category_id,
        public ?int            $partner_id,
        #[DataCollectionOf(DetailsData::class)]
        public ?DataCollection $details,
    ) {
        $this->sum = $this->details->toCollection()->sum('sum');
        $this->type = CashFlowType::Outflow;
    }
}
