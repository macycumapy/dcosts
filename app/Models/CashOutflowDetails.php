<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Детали расхода денежных средств
 *
 * @property int $id
 * @property float $count Количество номенклатуры
 * @property float $cost Стоимость номенклатуры
 * @property int $cash_outflow_id ID расхода
 * @property int $nomenclature_id ID номенклатуры
 *
 * @property-read CashOutflow $cashOutflow Расход денежных средств
 * @property-read Nomenclature $nomenclature Номенклатура
 * @property-read float $sum Сумма
 */
class CashOutflowDetails extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'count',
        'cost',
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

    /**
     * Сумма
     * @return float
     */
    public function getSumAttribute(): float
    {
        return round($this->count * $this->cost, 2);
    }
}
