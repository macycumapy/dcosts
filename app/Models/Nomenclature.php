<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\HasUserField;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Номенклатура
 *
 * @property int $id
 * @property string $name Наименование
 * @property int|null $nomenclature_type_id Идентификатор типа номенклатуры
 *
 * @property-read NomenclatureType $nomenclatureType Тип номенклатуры
 */
class Nomenclature extends Model
{
    use HasFactory;
    use HasUserField;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'user_id',
        'nomenclature_type_id',
    ];

    /**
     * Тип номенклатуры
     *
     * @return BelongsTo
     */
    public function nomenclatureType(): BelongsTo
    {
        return $this->belongsTo(NomenclatureType::class);
    }
}
