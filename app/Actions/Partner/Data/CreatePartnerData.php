<?php

declare(strict_types=1);

namespace App\Actions\Partner\Data;

use Spatie\LaravelData\Data;

class CreatePartnerData extends Data
{
    public string $name;
    public int $user_id;
}
