<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Расход денежных средств
 *
 * @property int $id
 * @property float $count Количество номенклатуры
 * @property float $cost Стоимость номенклатуры
 * @property float $sum Сумма
 * @property int $cash_outflow_id ID расхода
 * @property int $nomenclature_id ID номенклатуры
 *
 * @property-read CashOutflow $cashOutflow Расход денежных средств
 * @property-read Nomenclature $nomenclature Номенклатура
 */
class CashOutflowDetails extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'count',
        'cost',
        'sum',
        'cash_outflow_id',
        'nomenclature_id',
    ];

    /**
     * Расход денежных средств
     * @return BelongsTo
     */
    public function cashOutflow(): BelongsTo
    {
        return $this->belongsTo(CashOutflow::class);
    }

    /**
     * Номенклатура
     * @return BelongsTo
     */
    public function nomenclature(): BelongsTo
    {
        return $this->belongsTo(Nomenclature::class);
    }
}
