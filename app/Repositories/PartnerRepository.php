<?php

namespace App\Repositories;

use App\Models\Partner;

class PartnerRepository extends AbstractRepository
{
    /**
     * @param Partner $model
     */
    public function __construct(Partner $model)
    {
        parent::__construct($model);
    }
}