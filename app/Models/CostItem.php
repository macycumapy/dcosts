<?php

namespace App\Models;

use App\Casts\CastCashFlowType;
use App\Enums\CashFlowType;
use App\Models\Traits\HasUserField;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Статья затрат
 *
 * @property int $id
 * @property string $name Наименование
 * @property CashFlowType $type Тип движения
 * @property int|null $foreign_id Id внешнего источника
 */
class CostItem extends Model
{
    use HasFactory, HasUserField;

    public $timestamps = false;

    protected $casts = [
        'type' => CastCashFlowType::class,
    ];

    protected $fillable = [
        'name',
        'user_id',
        'type',
        'foreign_id',
    ];
}
