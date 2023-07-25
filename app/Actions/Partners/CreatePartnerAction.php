<?php

declare(strict_types=1);

namespace App\Actions\Partners;

use App\Actions\Partners\Data\PartnerCreateData;
use App\Models\Partner;

class CreatePartnerAction
{
    public function exec(PartnerCreateData $data): Partner
    {
        return Partner::create($data->toArray());
    }
}
