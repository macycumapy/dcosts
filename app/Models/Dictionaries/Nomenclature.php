<?php

namespace App\Models;

class Nomenclature extends AbstractDictionary implements NomenclatureInterface
{
    protected $fillable = [
        'name',
        'nomenclature_type_id',
    ];

    protected $nomenclatureType;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->nomenclatureType = app()->make(NomenclatureTypeInterface::class);
    }

    public static function rules(): array
    {
        return [
            'name' => 'string|required',
            'nomenclature_type_id' => 'integer|nullable',
        ];
    }
}
