<?php

namespace App\Models;

class CostItem extends AbstractDictionary implements CostItemInterface
{
    protected $fillable = [
        'name',
    ];

    public static function rules(): array
    {
        return [
          'name' => 'required|string'
        ];
    }
}
