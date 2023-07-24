<?php

declare(strict_types=1);

namespace App\Actions\NomenclatureTypes;

use App\Models\NomenclatureType;

class DeleteNomenclatureTypeAction
{
    public function exec(NomenclatureType $nomenclatureType): bool
    {
        return $nomenclatureType->delete();
    }
}
