<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractDictionary extends Model implements ModelInterface
{
    use CRUDTrait;

    public $timestamps = false;
}
