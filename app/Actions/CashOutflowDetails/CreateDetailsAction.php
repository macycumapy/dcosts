<?php

declare(strict_types=1);

namespace App\Actions\CashOutflowDetails;

use App\Actions\CashOutflowDetails\Data\DetailsData;
use App\Models\CashFlow;
use App\Models\CashOutflowDetails;

class CreateDetailsAction
{
    public function exec(CashFlow $cashFlow, DetailsData $data): CashOutflowDetails
    {
        $details = new CashOutflowDetails($data->toArray());
        $details->cashFlow()->associate($cashFlow);
        $details->save();

        return $details;
    }
}
