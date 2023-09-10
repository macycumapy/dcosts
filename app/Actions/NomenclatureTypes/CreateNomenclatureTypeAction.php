<?php

declare(strict_types=1);

namespace App\Actions\NomenclatureTypes;

use App\Actions\NomenclatureTypes\Data\CreateNomenclatureTypeData;
use App\Models\NomenclatureType;

class CreateNomenclatureTypeAction
{
    public function exec(CreateNomenclatureTypeData $data): NomenclatureType
    {
        return NomenclatureType::create($data->toArray());
    }
}
