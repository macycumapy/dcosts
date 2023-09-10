<?php

declare(strict_types=1);

namespace App\Actions\NomenclatureType;

use App\Actions\NomenclatureType\Data\CreateNomenclatureTypeData;
use App\Models\NomenclatureType;

class CreateNomenclatureTypeAction
{
    public function exec(CreateNomenclatureTypeData $data): NomenclatureType
    {
        return NomenclatureType::create($data->toArray());
    }
}
