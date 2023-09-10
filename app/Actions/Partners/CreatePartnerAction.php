<?php

declare(strict_types=1);

namespace App\Actions\Partners;

use App\Actions\Partners\Data\CreatePartnerData;
use App\Models\Partner;

class CreatePartnerAction
{
    public function exec(CreatePartnerData $data): Partner
    {
        return Partner::create($data->toArray());
    }
}
