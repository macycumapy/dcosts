<?php

declare(strict_types=1);

namespace App\Actions\Partners;

use App\Actions\Partners\Data\PartnerUpdateData;
use App\Models\Partner;

class UpdatePartnerAction
{
    public function exec(Partner $partner, PartnerUpdateData $data): bool
    {
        return $partner->update($data->toArray());
    }
}
