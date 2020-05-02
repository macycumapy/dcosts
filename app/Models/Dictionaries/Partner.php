<?php

namespace App\Models\Dictionaries;

use App\Models\Traits\UserRelatedModelTrait;

class Partner extends AbstractDictionary implements PartnerInterface
{
    use UserRelatedModelTrait;

    protected $fillable = [
        'name',
        'user_id',
    ];

    public static function rules():array
    {
        return [
            'name' => 'required|string',
        ];
    }
}
