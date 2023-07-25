<?php

declare(strict_types=1);

namespace App\Actions\Partners;

use App\Models\Partner;

class DeletePartnerAction
{
    public function exec(Partner $partner): bool
    {
        return $partner->delete();
    }
}
