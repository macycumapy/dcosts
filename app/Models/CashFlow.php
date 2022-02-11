<?php

namespace App\Models;

use App\Casts\CastCashFlowType;
use App\Enums\CashFlowType;
use App\Models\Traits\HasUserField;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Движение денежных средств
 *
 * @property int $id
 * @property float $sum Сумма движения
 * @property string $date Дата движения
 * @property string $created_at Дата создания
 * @property string $updated_at Дата обновления
 * @property int|null $cost_item_id ID статьи затрат
 * @property int|null $partner_id ID контрагента
 * @property CashFlowType $type Тип движения
 * @property int|null $foreign_id Id внешнего источника
 *
 * @property-read CostItem|null $costItem Статья затрат
 * @property-read Partner|null $partner Контрагент
 * @property-read Collection<CashOutflowDetails> $details Детали затрат
 */
class CashFlow extends Model
{
    use HasFactory, HasUserField;

    protected $casts = [
        'sum' => 'float',
        'type' => CastCashFlowType::class,
    ];

    public $fillable = [
        'sum',
        'date',
        'cost_item_id',
        'partner_id',
        'user_id',
        'type',
        'foreign_id',
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
     * Контрагент
     *
     * @return BelongsTo
     */
    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class);
    }

    /**
     * Детализация затрат
     * @return HasMany
     */
    public function details(): HasMany
    {
        return $this->hasMany(CashOutflowDetails::class, 'cash_outflow_id');
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeOfOutflows(Builder $query): Builder
    {
        return $query->where('type', CashFlowType::Outflow->value);
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeOfInflows(Builder $query): Builder
    {
        return $query->where('type', CashFlowType::Inflow->value);
    }
}
