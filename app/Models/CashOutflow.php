<?php

namespace App\Models;

use App\Models\Traits\Userable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Расход денежных средств
 *
 * @property int $id
 * @property float $sum Итоговая сумма расхода
 * @property string $date Дата расхода
 * @property string $created_at Дата создания
 * @property string $updated_at Дата обновления
 * @property int|null $cost_item_id ID Статьи затрат
 *
 * @property-read CostItem|null $costItem Статья затрат
 * @property-read Collection<CashOutflowDetails> $details Детали затрат
 */
class CashOutflow extends Model
{
    use HasFactory, Userable;

    protected $casts = [
      'sum' => 'float',
    ];

    public $fillable = [
      'sum',
      'date',
      'cost_item_id',
      'user_id',
    ];

    /**
     * Статья затрат
     *
     * @return BelongsTo
     */
    public function costItem(): BelongsTo
    {
        return $this->belongsTo(CostItem::class);
    }

    /**
     * Детализация затрат
     * @return HasMany
     */
    public function details(): HasMany
    {
        return $this->hasMany(CashOutflowDetails::class);
    }
}
