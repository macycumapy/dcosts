<?php

namespace App\Models\Dictionaries;

use App\Models\Traits\UserRelatedModelTrait;

class Partner extends AbstractDictionary
{
    use UserRelatedModelTrait;

    protected $fillable = [
        'name',
        'user_id',
    ];

}
