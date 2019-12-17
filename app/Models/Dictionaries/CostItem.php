<?php

namespace App\Models;

class CostItem extends AbstractDictionary implements CostItemInterface
{
    use UserRelatedModelTrait;

    protected $fillable = [
        'name',
        'user_id',
    ];

    public static function rules(): array
    {
        return [
          'name' => 'required|string'
        ];
    }
}
