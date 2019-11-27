<?php

namespace App\Models;

class NomenclatureType extends AbstractDictionary implements NomenclatureTypeInterface
{
    protected $fillable = [
        'name',
    ];

    private $nomenclature;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->nomenclature = app()->make(NomenclatureInterface::class);
    }

    public function rules(): array
    {
        return [
            'name' => 'string|required',
        ];
    }

    public function nomenclatures()
    {
        return $this->hasMany($this->nomenclature);
    }
}
