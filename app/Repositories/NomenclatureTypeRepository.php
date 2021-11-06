<?php

namespace App\Repositories;

use App\Models\NomenclatureType;

class NomenclatureTypeRepository extends AbstractRepository
{
    /**
     * @param NomenclatureType $model
     */
    public function __construct(NomenclatureType $model)
    {
        parent::__construct($model);
    }
}