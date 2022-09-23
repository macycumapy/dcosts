<?php

declare(strict_types=1);

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
