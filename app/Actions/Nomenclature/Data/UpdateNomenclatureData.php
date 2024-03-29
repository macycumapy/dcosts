<?php

declare(strict_types=1);

namespace App\Actions\Nomenclature\Data;

use Spatie\LaravelData\Data;

class UpdateNomenclatureData extends Data
{
    public string $name;
    public ?int $nomenclature_type_id = null;
}
