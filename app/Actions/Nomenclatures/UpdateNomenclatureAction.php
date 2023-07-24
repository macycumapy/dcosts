<?php

declare(strict_types=1);

namespace App\Actions\Nomenclatures;

use App\Actions\Nomenclatures\Data\NomenclatureUpdateData;
use App\Models\Nomenclature;

class UpdateNomenclatureAction
{
    public function exec(Nomenclature $nomenclature, NomenclatureUpdateData $data): bool
    {
        return $nomenclature->update($data->toArray());
    }
}
