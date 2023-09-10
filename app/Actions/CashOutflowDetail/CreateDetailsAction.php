<?php

declare(strict_types=1);

namespace App\Actions\CashOutflowDetail;

use App\Actions\CashOutflowDetail\Data\DetailsData;
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
