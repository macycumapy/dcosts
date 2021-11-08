<?php

namespace App\Models;

use App\Models\Traits\Userable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Контрагент
 *
 * @property int $id
 * @property string $name Наименование
 */
class Partner extends Model
{
    use HasFactory, Userable;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'user_id',
    ];
}
