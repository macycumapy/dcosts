<?php

declare(strict_types=1);

namespace App\Actions\Category\Data;

use App\Enums\CashFlowType;
use Spatie\LaravelData\Data;

class CreateCategoryData extends Data
{
    public string $name;
    public CashFlowType $type;
    public int $user_id;
}
