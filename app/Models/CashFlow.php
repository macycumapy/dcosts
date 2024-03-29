<?php

declare(strict_types=1);

namespace App\Models;

use App\Builder\CashFlowBuilder;
use App\Enums\CashFlowType;
use App\Models\Scopes\SampleByUser;
use App\Models\Traits\HasUserField;
use Carbon\Carbon;
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
 * @property Carbon $date Дата движения
 * @property string $created_at Дата создания
 * @property string $updated_at Дата обновления
 * @property int|null $category_id ID статьи затрат
 * @property int|null $partner_id ID контрагента
 * @property CashFlowType $type Тип движения
 * @property-read Category|null $category Статья затрат
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
        'date' => 'datetime'
    ];

    public $fillable = [
        'sum',
        'date',
        'category_id',
        'partner_id',
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

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(CashOutflowDetails::class);
    }
}
