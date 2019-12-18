<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

interface PartnerInterface extends ModelInterface
{
    public function user():BelongsTo;

    public static function allByUserId($id, $columns = ['*']);
}
