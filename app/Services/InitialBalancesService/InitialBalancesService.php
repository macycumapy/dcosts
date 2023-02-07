<?php

declare(strict_types=1);

namespace App\Services\InitialBalancesService;

use App\Repositories\CashInflowRepository;
use App\Repositories\CostItemRepository;
use App\Repositories\PartnerRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InitialBalancesService
{
    public function __construct(
        private readonly PartnerRepository $partnerRepository,
        private readonly CostItemRepository $costItemRepository,
        private readonly CashInflowRepository $cashInflowRepository,
    ) {
    }

    public function uploadInflows(UploadedFile $file): Collection
    {
        $inflowsData = app(InflowsXlsxParser::class)->parse($file->get());

        return DB::transaction(function () use ($inflowsData) {
            return collect($inflowsData)->map(function ($inflow) {
                $partner = $this->partnerRepository->firstOrCreate($inflow->partnerName);
                $costItem = $this->costItemRepository->firstOrCreate($inflow->costItemName);

                return $this->cashInflowRepository->create([
                    'user_id' => Auth::id(),
                    'partner_id' => $partner->id,
                    'cost_item_id' => $costItem->id,
                    'date' => $inflow->date,
                    'sum' => $inflow->sum,
                ]);
            });
        });
    }
}
