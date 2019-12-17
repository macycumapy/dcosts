<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

interface NomenclatureTypeInterface extends ModelInterface
{
    public function nomenclatures():HasMany;

    public function user():BelongsTo;

    public static function allByUserId($id, $columns = ['*']);
}
