<?php

namespace App\Models;

use App\Models\Traits\Userable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Поступление денежных средств
 *
 * @property int $id
 * @property float $sum Сумма поступления
 * @property string $date Дата поступления
 * @property string $created_at Дата создания
 * @property string $updated_at Дата обновления
 * @property int|null $cost_item_id ID статьи затрат
 * @property int|null $partner_id ID контрагента
 *
 * @property-read CostItem|null $costItem Статья затрат
 * @property-read Partner|null $partner Контрагент
 */
class CashInflow extends Model
{
    use HasFactory, Userable;

    protected $casts = [
        'sum' => 'float',
    ];

    public $fillable = [
        'sum',
        'date',
        'cost_item_id',
        'partner_id',
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
     * Контрагент
     *
     * @return BelongsTo
     */
    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class);
    }
}
