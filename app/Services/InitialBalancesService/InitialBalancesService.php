<?php

declare(strict_types=1);

namespace App\Services\InitialBalancesService;

use App\Enums\CashFlowType;
use App\Repositories\CashInflowRepository;
use App\Repositories\CashOutflowRepository;
use App\Repositories\CostItemRepository;
use App\Repositories\NomenclatureRepository;
use App\Repositories\NomenclatureTypeRepository;
use App\Repositories\PartnerRepository;
use App\Services\InitialBalancesService\DTO\OutflowDetailsDTO;
use App\Services\InitialBalancesService\DTO\OutflowDTO;
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
        private readonly CashOutflowRepository $cashOutflowRepository,
        private readonly NomenclatureRepository $nomenclatureRepository,
        private readonly NomenclatureTypeRepository $nomenclatureTypeRepository,
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

    public function uploadOutflows(UploadedFile $file): Collection
    {
        $outflowData = app(OutflowXlsxParser::class)->parse($file->get());

        return DB::transaction(function () use ($outflowData) {
            return collect($outflowData)->map(function (OutflowDTO $outflow) {
                $costItem = $this->costItemRepository->firstOrCreate($outflow->costItemName, CashFlowType::Outflow);

                return $this->cashOutflowRepository->create([
                    'user_id' => Auth::id(),
                    'cost_item_id' => $costItem->id,
                    'date' => $outflow->date,
                    'sum' => $outflow->sum,
                    'details' => collect($outflow->details)
                        ->map(function (OutflowDetailsDTO $details) {
                            $nomenclatureType = $this->nomenclatureTypeRepository->firstOrCreate($details->nomenclatureType);
                            $nomenclature = $this->nomenclatureRepository->firstOrCreate($details->nomenclatureName, $nomenclatureType);

                            return [
                                'count' => $details->count,
                                'cost' => $details->cost,
                                'nomenclature_id' => $nomenclature->id,
                            ];
                        })->toArray()
                ]);
            });
        });
    }
}
