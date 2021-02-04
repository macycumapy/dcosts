<?php

namespace App\Models\Dictionaries;

use App\Models\Traits\UserRelatedModelTrait;

class Nomenclature extends AbstractDictionary
{
    use UserRelatedModelTrait;

    protected $fillable = [
        'name',
        'nomenclature_type_id',
        'user_id',
    ];
}
