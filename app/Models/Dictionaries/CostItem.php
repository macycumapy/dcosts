<?php

namespace App\Models\Dictionaries;

use App\Models\Traits\UserRelatedModelTrait;

class CostItem extends AbstractDictionary
{
    use UserRelatedModelTrait;

    protected $fillable = [
        'name',
        'user_id',
    ];
}
