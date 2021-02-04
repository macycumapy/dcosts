<?php

namespace App\Models\Dictionaries;

use App\Models\Traits\UserRelatedModelTrait;

class NomenclatureType extends AbstractDictionary
{
    use UserRelatedModelTrait;

    protected $fillable = [
        'name',
        'user_id',
    ];
}
