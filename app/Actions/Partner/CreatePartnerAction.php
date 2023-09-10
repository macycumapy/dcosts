<?php

declare(strict_types=1);

namespace App\Actions\Partner;

use App\Actions\Partner\Data\CreatePartnerData;
use App\Models\Partner;

class CreatePartnerAction
{
    public function exec(CreatePartnerData $data): Partner
    {
        return Partner::create($data->toArray());
    }
}
