<?php

namespace App\Models\Dictionaries;

use App\Models\Traits\UserRelatedModelTrait;

class Nomenclature extends AbstractDictionary implements NomenclatureInterface
{
    use UserRelatedModelTrait;

    protected $fillable = [
        'name',
        'nomenclature_type_id',
        'user_id',
    ];

    protected $nomenclatureType;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->nomenclatureType = app()->make(NomenclatureTypeInterface::class);
    }

    public static function boot()
    {
        parent::boot();

        static::saving(function ($model){
            if ($model->nomenclature_type_id)
                $model->nomenclatureType = $model->findOrAbort($model->nomenclatureType,$model->nomenclature_type_id);
        });
    }

    public static function rules(): array
    {
        return [
            'name' => 'string|required',
            'nomenclature_type_id' => 'integer|nullable',
        ];
    }
}
