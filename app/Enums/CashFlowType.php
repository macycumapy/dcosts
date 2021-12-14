<?php

namespace App\Enums;

enum CashFlowType:string
{
    case Inflow = 'Inflow';
    case Outflow = 'Outflow';

    public static function values(): array
    {
        return array_map(static fn(self $item) => $item->value, self::cases());
    }
}
