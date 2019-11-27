<?php

namespace App\Models;

class NomenclatureType extends AbstractDictionary implements NomenclatureTypeInterface
{
    protected $fillable = [
        'name',
    ];

    public function rules(): array
    {
        return [
            'name' => 'string|required',
        ];
    }
}
