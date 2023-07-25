<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Scopes\SampleByUser;
use App\Models\Traits\HasUserField;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Контрагент
 *
 * @property int $id
 * @property string $name Наименование
 * @mixin Builder
 */
class Partner extends Model
{
    use HasFactory;
    use HasUserField;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'user_id',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::addGlobalScope(new SampleByUser());
    }
}
