<?php

declare(strict_types=1);

namespace App\Actions\Partners\Data;

use Spatie\LaravelData\Data;

class PartnerCreateData extends Data
{
    public string $name;
    public int $user_id;
}
