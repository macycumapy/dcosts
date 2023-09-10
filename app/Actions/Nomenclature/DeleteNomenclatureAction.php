<?php

declare(strict_types=1);

namespace App\Actions\Nomenclature;

use App\Models\Nomenclature;

class DeleteNomenclatureAction
{
    public function exec(Nomenclature $nomenclature): bool
    {
        return $nomenclature->delete();
    }
}
