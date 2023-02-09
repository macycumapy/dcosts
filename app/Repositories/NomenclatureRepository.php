<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Nomenclature;
use App\Models\NomenclatureType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class NomenclatureRepository extends AbstractRepository
{
    /**
     * @param Nomenclature $model
     */
    public function __construct(Nomenclature $model)
    {
        parent::__construct($model);
    }

    public function firstOrCreate(string $name, ?NomenclatureType $nomenclatureType): Nomenclature
    {
        return $this->query->firstOrCreate([
            'name' => Str::ucfirst($name),
            'nomenclature_type_id' => $nomenclatureType->id,
            'user_id' => Auth::id(),
        ], [
            'name' => Str::ucfirst($name),
            'nomenclature_type_id' => $nomenclatureType->id,
            'user_id' => Auth::id(),
        ]);
    }
}
