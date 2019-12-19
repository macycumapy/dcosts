<?php

namespace App\Models\Documents;

use App\Models\CRUDTrait;
use App\Models\UserRelatedModelTrait;
use Illuminate\Database\Eloquent\Model;

class CashInflow extends Model implements CashInflowInterface
{
    use CRUDTrait, UserRelatedModelTrait;

    protected $fillable = [
        'cost_item_id',
        'date',
        'user_id',
        'partner_id',
        'sum',
    ];

    public static function rules(): array
    {
        return [
            'date' => 'date|required',
            'cost_item_id' => 'integer|nullable',
            'partner_id' => 'integer|nullable',
            'sum' => 'numeric|required',
        ];
    }
}
