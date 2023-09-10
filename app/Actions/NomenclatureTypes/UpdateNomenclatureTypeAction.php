<?php

declare(strict_types=1);

namespace App\Actions\NomenclatureTypes;

use App\Actions\NomenclatureTypes\Data\UpdateNomenclatureTypeData;
use App\Models\NomenclatureType;

class UpdateNomenclatureTypeAction
{
    public function exec(NomenclatureType $nomenclatureType, UpdateNomenclatureTypeData $data): bool
    {
        return $nomenclatureType->update($data->toArray());
    }
}
