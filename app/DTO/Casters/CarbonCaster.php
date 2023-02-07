<?php

declare(strict_types=1);

namespace App\DTO\Casters;

use Carbon\Carbon;
use Spatie\DataTransferObject\Caster;
use Throwable;

class CarbonCaster implements Caster
{
    public function cast(mixed $value): Carbon|null
    {
        try {
            return Carbon::make($value);
        } catch (Throwable) {
            return null;
        }
    }
}
