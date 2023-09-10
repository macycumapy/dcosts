<?php

declare(strict_types=1);

namespace App\Actions\Partners;

use App\Actions\Partners\Data\UpdatePartnerData;
use App\Models\Partner;

class UpdatePartnerAction
{
    public function exec(Partner $partner, UpdatePartnerData $data): bool
    {
        return $partner->update($data->toArray());
    }
}
