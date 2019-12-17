<?php


namespace App\Models\Documents;


use App\Models\ModelInterface;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

Interface CashFlowInterface extends ModelInterface
{
    public function details():HasMany;

    public function firstWithDetails();

    public function addDetails(array $details);

    public function updateDetails(array $details);

    public function user():BelongsTo;

    public static function allByUserId($id, $columns = ['*']);
}
