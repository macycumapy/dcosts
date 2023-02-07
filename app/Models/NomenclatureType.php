<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\HasUserField;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Тип номенклатуры
 *
 * @property int $id
 * @property string $name Наименование
 */
class NomenclatureType extends Model
{
    use HasFactory;
    use HasUserField;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'user_id',
    ];
}
