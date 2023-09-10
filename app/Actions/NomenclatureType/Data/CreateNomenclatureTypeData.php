<?php

declare(strict_types=1);

namespace App\Actions\NomenclatureType\Data;

use Spatie\LaravelData\Data;

class CreateNomenclatureTypeData extends Data
{
    public string $name;
    public int $user_id;
}
