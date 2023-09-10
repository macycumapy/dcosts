<?php

declare(strict_types=1);

namespace App\Actions\Nomenclature;

use App\Actions\Nomenclature\Data\UpdateNomenclatureData;
use App\Models\Nomenclature;

class UpdateNomenclatureAction
{
    public function exec(Nomenclature $nomenclature, UpdateNomenclatureData $data): bool
    {
        return $nomenclature->update($data->toArray());
    }
}
