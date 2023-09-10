<?php

declare(strict_types=1);

namespace App\Actions\CashFlow;

use App\Actions\CashFlow\Data\UpdateCashOutflowData;
use App\Actions\CashOutflowDetail\CreateDetailsAction;
use App\Actions\CashOutflowDetail\Data\DetailsData;
use App\Actions\CashOutflowDetail\UpdateDetailsAction;
use App\Models\CashFlow;
use App\Models\CashOutflowDetails;
use Illuminate\Support\Facades\DB;

class UpdateCashOutflowAction
{
    public function __construct(
        private readonly CreateDetailsAction $createDetailsAction,
        private readonly UpdateDetailsAction $updateDetailsAction,
    ) {
    }

    public function exec(CashFlow $cashFlow, UpdateCashOutflowData $data): CashFlow
    {
        return DB::transaction(function () use ($data, $cashFlow) {
            $cashFlow->date = $data->date;
            $cashFlow->category()->associate($data->category_id);
            $cashFlow->partner()->associate($data->partner_id);
            $cashFlow->sum = $data->sum;
            $cashFlow->save();

            $this->updateDetails($cashFlow, $data);
            $cashFlow->load('details');

            return $cashFlow;
        });
    }

    private function updateDetails(CashFlow $cashFlow, UpdateCashOutflowData $data): void
    {
        $detailsToRemove = $cashFlow->details();

        /** @var DetailsData $detail */
        foreach ($data->details as $detail) {
            if (isset($detail->id)) {
                /** @var CashOutflowDetails $foundedDetails */
                $foundedDetails = $cashFlow->details->firstWhere('id', $detail->id);
                if ($foundedDetails) {
                    $this->updateDetailsAction->exec($foundedDetails, $detail);
                    $detailsToRemove->where('id', '<>', $detail->id);
                } else {
                    $newDetails = $this->createDetailsAction->exec($cashFlow, $detail);
                    $detailsToRemove->where('id', '<>', $newDetails->id);
                }
            } else {
                $newDetails = $this->createDetailsAction->exec($cashFlow, $detail);
                $detailsToRemove->where('id', '<>', $newDetails->id);
            }
        }

        if ($detailsToRemove->exists()) {
            $detailsToRemove->delete();
        }
    }
}
