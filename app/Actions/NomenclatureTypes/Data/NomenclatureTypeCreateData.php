<?php

declare(strict_types=1);

namespace App\Actions\NomenclatureTypes\Data;

use App\Models\User;
use Spatie\LaravelData\Data;

class NomenclatureTypeCreateData extends Data
{
    public string $name;
    public int $user_id;
}
