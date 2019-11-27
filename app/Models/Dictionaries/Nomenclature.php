<?php

namespace App\Models;

class Nomenclature extends AbstractDictionary implements NomenclatureInterface
{
    protected $fillable = [
        'name',
        'nomenclature_type_id',
    ];

    public function rules(): array
    {
        return [
            'name' => 'string|required',
            'nomenclature_type_id' => 'integer|required',
        ];
    }

    public function nomenclatureType()
    {
        return $this->belongsTo(NomenclatureTypeInterface::class);
    }
}
