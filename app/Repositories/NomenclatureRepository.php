<?php

namespace App\Repositories;

use App\Models\Nomenclature;

class NomenclatureRepository extends AbstractRepository
{
    /**
     * @param Nomenclature $model
     */
    public function __construct(Nomenclature $model)
    {
        parent::__construct($model);
    }
}