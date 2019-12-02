<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

interface NomenclatureTypeInterface extends ModelInterface
{
    public function nomenclatures():HasMany;
}
