<?php

declare(strict_types=1);

namespace App\Models;

use App\Builder\CashFlowBuilder;
use App\Enums\CashFlowType;
use App\Models\Scopes\SampleByUser;
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
 * @property-read CostItem|null $costItem Статья затрат
 * @property-read Partner|null $partner Контрагент
 * @property-read Collection<CashOutflowDetails> $details Детали затрат
 * @mixin CashFlowBuilder
 */
class CashFlow extends Model
{
    use HasFactory;
    use HasUserField;

    protected $casts = [
        'sum' => 'float',
        'type' => CashFlowType::class,
    ];

    public $fillable = [
        'sum',
        'date',
        'cost_item_id',
        'partner_id',
        'user_id',
        'type',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::addGlobalScope(new SampleByUser());
    }

    public function newEloquentBuilder($query): Builder
    {
        return new CashFlowBuilder($query);
    }

    public function costItem(): BelongsTo
    {
        return $this->belongsTo(CostItem::class);
    }

    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(CashOutflowDetails::class, 'cash_outflow_id');
    }
}
