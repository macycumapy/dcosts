<?php

declare(strict_types=1);

namespace App\Actions\Nomenclatures\Data;

use Spatie\LaravelData\Data;

class CreateNomenclatureData extends Data
{
    public string $name;
    public int $user_id;
    public ?int $nomenclature_type_id = null;
}
