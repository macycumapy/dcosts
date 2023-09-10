<?php

declare(strict_types=1);

namespace App\Actions\CashFlows\Data;

use App\Actions\CashOutflowDetails\Data\DetailsData;
use Carbon\Carbon;
use Spatie\LaravelData\Attributes\Computed;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class UpdateCashOutflowData extends Data
{
    #[Computed]
    public readonly float $sum;

    public function __construct(
        public Carbon          $date,
        public ?int            $cost_item_id,
        public ?int            $partner_id,
        #[DataCollectionOf(DetailsData::class)]
        public ?DataCollection $details,
    ) {
        $this->sum = $this->details->toCollection()->sum('sum');
    }
}
