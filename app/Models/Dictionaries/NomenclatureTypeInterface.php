<?php

namespace App\Models\Dictionaries;

use App\Models\ModelInterface;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

interface NomenclatureTypeInterface extends ModelInterface
{
    public function nomenclatures():HasMany;

    public function user():BelongsTo;

    public static function allByUserId($id, $columns = ['*']);
}
