<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Partner;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PartnerRepository extends AbstractRepository
{
    /**
     * @param Partner $model
     */
    public function __construct(Partner $model)
    {
        parent::__construct($model);
    }

    public function firstOrCreate(string $name): Partner
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
