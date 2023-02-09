<?php

declare(strict_types=1);

namespace App\Services\InitialBalancesService\DTO;

use App\DTO\Casters\CarbonCaster;
use App\DTO\Traits\MakeSelf;
use Carbon\Carbon;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Casters\ArrayCaster;
use Spatie\DataTransferObject\DataTransferObject;

class OutflowDTO extends DataTransferObject
{
    use MakeSelf;

    #[CastWith(CarbonCaster::class)]
    public Carbon $date;
    public float $sum;
    public string $costItemName;

    #[CastWith(ArrayCaster::class, OutflowDetailsDTO::class)]
    public array $details;
}
