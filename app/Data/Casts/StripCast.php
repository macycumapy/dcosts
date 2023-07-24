<?php

declare(strict_types=1);

namespace App\Data\Casts;

use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\DataProperty;

class StripCast implements Cast
{
    public function cast(DataProperty $property, mixed $value, array $context): ?string
    {
        if (!$value) {
            return null;
        }

        $res = str_replace([' ', '-', '/'], '', $value);

        return $res ?: null;
    }
}
