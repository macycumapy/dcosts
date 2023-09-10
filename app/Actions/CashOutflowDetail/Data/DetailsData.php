<?php

declare(strict_types=1);

namespace App\Actions\CashOutflowDetail\Data;

use Spatie\LaravelData\Attributes\Computed;
use Spatie\LaravelData\Data;

class DetailsData extends Data
{
    #[Computed]
    public readonly float $sum;

    public function __construct(
        public int   $count,
        public float $cost,
        public int   $nomenclature_id,
        public ?int  $id = null,
    ) {
        $this->sum = $this->cost * $this->count;
    }
}
