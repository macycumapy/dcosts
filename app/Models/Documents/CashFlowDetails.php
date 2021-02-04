<?php

namespace App\Models\Documents;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CashFlowDetails
 *
 * @property int id
 * @property int cash_flow_id       id расхода
 * @property int nomenclature_id    id номенклатуры
 * @property int quantity           Количество
 * @property float cost             Цена
 *
 * @package App\Models\Documents
 */
class CashFlowDetails extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'cash_flow_id',
        'nomenclature_id',
        'quantity',
        'cost',
    ];
}
