<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\NomenclatureType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class NomenclatureTypeRepository extends AbstractRepository
{
    /**
     * @param NomenclatureType $model
     */
    public function __construct(NomenclatureType $model)
    {
        parent::__construct($model);
    }

    public function firstOrCreate(string $name): NomenclatureType
    {
        return $this->query->firstOrCreate([
            'name' => Str::ucfirst($name),
            'user_id' => Auth::id(),
        ], [
            'name' => Str::ucfirst($name),
            'user_id' => Auth::id(),
        ]);
    }
}
