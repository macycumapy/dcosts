<?php

declare(strict_types=1);

namespace App\Actions\CashOutflowDetail;

use App\Actions\CashOutflowDetail\Data\DetailsData;
use App\Models\CashOutflowDetails;

class UpdateDetailsAction
{
    public function exec(CashOutflowDetails $details, DetailsData $data): bool
    {
        return $details->update($data->toArray());
    }
}
