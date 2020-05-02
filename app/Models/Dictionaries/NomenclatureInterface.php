<?php

namespace App\Models\Dictionaries;

use App\Models\ModelInterface;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

interface NomenclatureInterface extends ModelInterface
{
    public function user():BelongsTo;

    public static function allByUserId($id, $columns = ['*']);
}
