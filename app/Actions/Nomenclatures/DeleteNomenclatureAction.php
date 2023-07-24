<?php

declare(strict_types=1);

namespace App\Actions\Nomenclatures;

use App\Models\Nomenclature;

class DeleteNomenclatureAction
{
    public function exec(Nomenclature $nomenclature): bool
    {
        return $nomenclature->delete();
    }
}
