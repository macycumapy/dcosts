<?php


namespace App\Models\Documents;


use App\Models\ModelInterface;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

Interface CashInflowInterface extends ModelInterface
{
    public function user():BelongsTo;

    public static function allByUserId($id, $columns = ['*']);
}
