<?php

namespace App\Models\Dictionaries;

use App\Models\Traits\CRUDTrait;
use App\Models\ModelInterface;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractDictionary extends Model implements ModelInterface
{
    use CRUDTrait;

    public $timestamps = false;
}
