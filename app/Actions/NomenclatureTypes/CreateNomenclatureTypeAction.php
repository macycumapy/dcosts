<?php

declare(strict_types=1);

namespace App\Actions\NomenclatureTypes;

use App\Actions\NomenclatureTypes\Data\NomenclatureTypeCreateData;
use App\Models\NomenclatureType;

class CreateNomenclatureTypeAction
{
    public function exec(NomenclatureTypeCreateData $data): NomenclatureType
    {
        return NomenclatureType::create($data->toArray());
    }
}
