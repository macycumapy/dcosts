<?php

namespace App\Models\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

Trait UserRelatedModelTrait
{
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function allByUserId($id, $columns = ['*'])
    {
        return static::query()->where('user_id', $id)->get(
            is_array($columns) ? $columns : func_get_args()
        );
    }
}
