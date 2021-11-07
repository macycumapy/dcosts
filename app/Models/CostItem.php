<?php

namespace App\Models;

use App\Models\Traits\Userable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Статья затрат
 *
 * @property int $id
 * @property string $name Наименование
 */
class CostItem extends Model
{
    use HasFactory, Userable;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'user_id',
    ];
}
