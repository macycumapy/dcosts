<?php

declare(strict_types=1);

namespace App\Enums;

enum CashFlowType: string
{
    case Inflow = 'inflow';
    case Outflow = 'outflow';

    public static function values(): array
    {
        return array_map(static fn (self $item) => $item->value, self::cases());
    }
}
