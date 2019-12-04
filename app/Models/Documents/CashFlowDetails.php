<?php

namespace App\Models\Documents;

use App\Models\CRUDTrait;
use Illuminate\Database\Eloquent\Model;

class CashFlowDetails extends Model implements CashFlowDetailsInterface
{
    use CRUDTrait;

    public $timestamps = false;

    protected $fillable = [
        'cash_flow_id',
        'nomenclature_id',
        'quantity',
        'cost',
        'comment',
    ];

    public static function rules():array {
        return [
            'cash_flow_id' => 'required|integer',
            'nomenclature_id' => 'required|integer',
            'quantity' => 'required|integer',
            'cost' => 'required|number',
            'comment' => 'string',
        ];
    }
}
