<?php

declare(strict_types=1);

namespace App\Services\InitialBalancesService\DTO;

use App\DTO\Traits\MakeSelf;
use Spatie\DataTransferObject\DataTransferObject;

class OutflowDetailsDTO extends DataTransferObject
{
    use MakeSelf;

    public string $nomenclatureName;
    public ?string $nomenclatureType;
    public ?string $comment;
    public float $count;
    public float $cost;
}
