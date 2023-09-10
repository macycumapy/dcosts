<?php

declare(strict_types=1);

namespace App\Actions\Nomenclatures;

use App\Actions\Nomenclatures\Data\CreateNomenclatureData;
use App\Models\Nomenclature;

class CreateNomenclatureAction
{
    public function exec(CreateNomenclatureData $data): Nomenclature
    {
        return Nomenclature::create($data->toArray());
    }
}
