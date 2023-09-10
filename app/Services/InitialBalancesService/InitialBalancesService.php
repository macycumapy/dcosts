<?php

declare(strict_types=1);

namespace App\Services\InitialBalancesService;

use App\Actions\CashFlows\CreateCashFlowAction;
use App\Actions\CashFlows\CreateCashOutflowAction;
use App\Actions\CashFlows\Data\CreateCashFlowData;
use App\Actions\CashFlows\Data\CreateCashOutflowData;
use App\Actions\CashOutflowDetails\Data\DetailsData;
use App\Actions\CostItems\CreateCostItemAction;
use App\Actions\CostItems\Data\CreateCostItemData;
use App\Actions\Nomenclatures\CreateNomenclatureAction;
use App\Actions\Nomenclatures\Data\CreateNomenclatureData;
use App\Actions\NomenclatureTypes\CreateNomenclatureTypeAction;
use App\Actions\NomenclatureTypes\Data\CreateNomenclatureTypeData;
use App\Actions\Partners\CreatePartnerAction;
use App\Actions\Partners\Data\CreatePartnerData;
use App\Enums\CashFlowType;
use App\Models\CostItem;
use App\Models\Nomenclature;
use App\Models\NomenclatureType;
use App\Models\Partner;
use App\Services\InitialBalancesService\Data\OutflowData;
use App\Services\InitialBalancesService\Data\OutflowDetailsData;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InitialBalancesService
{
    public function __construct(
        private readonly CreatePartnerAction $createPartnerAction,
        private readonly CreateCostItemAction $createCostItemAction,
        private readonly CreateCashFlowAction $createCashFlowAction,
        private readonly CreateCashOutflowAction $createCashOutflowAction,
        private readonly CreateNomenclatureAction $createNomenclatureAction,
        private readonly CreateNomenclatureTypeAction $createNomenclatureTypeAction,
    ) {
    }

    public function uploadInflows(UploadedFile $file): Collection
    {
        $inflowsData = app(InflowsXlsxParser::class)->parse($file->get());

        return DB::transaction(function () use ($inflowsData) {
            return collect($inflowsData)->map(function ($inflow) {
                /** @var Partner $partner */
                $partner = Partner::firstWhere('name', $inflow->partnerName);
                if (!$partner) {
                    $partner = $this->createPartnerAction->exec(CreatePartnerData::from([
                        'name' => $inflow->partnerName,
                        'user_id' => Auth::id(),
                    ]));
                }

                /** @var CostItem $costItem */
                $costItem = CostItem::firstWhere('name', $inflow->costItemName);
                if (!$costItem) {
                    $costItem = $this->createCostItemAction->exec(CreateCostItemData::from([
                        'name' => $inflow->costItemName,
                        'type' => CashFlowType::Inflow,
                        'user_id' => Auth::id(),
                    ]));
                }

                return $this->createCashFlowAction->exec(CreateCashFlowData::from([
                    'user_id' => Auth::id(),
                    'partner_id' => $partner->id,
                    'cost_item_id' => $costItem->id,
                    'date' => $inflow->date,
                    'sum' => $inflow->sum,
                    'type' => CashFlowType::Inflow,
                ]));
            });
        });
    }

    public function uploadOutflows(UploadedFile $file): Collection
    {
        $outflowData = app(OutflowXlsxParser::class)->parse($file->get());

        return DB::transaction(function () use ($outflowData) {
            return collect($outflowData)->map(function (OutflowData $outflow) {
                /** @var CostItem $costItem */
                $costItem = CostItem::firstWhere('name', $outflow->costItemName);
                if (!$costItem) {
                    $costItem = $this->createCostItemAction->exec(CreateCostItemData::from([
                        'name' => $outflow->costItemName,
                        'type' => CashFlowType::Outflow,
                        'user_id' => Auth::id(),
                    ]));
                }

                return $this->createCashOutflowAction->exec(CreateCashOutflowData::from([
                    'user_id' => Auth::id(),
                    'cost_item_id' => $costItem->id,
                    'date' => $outflow->date,
                    'sum' => $outflow->sum,
                    'details' => $outflow->details
                        ->map(function (OutflowDetailsData $details) {
                            /** @var NomenclatureType $nomenclatureType */
                            $nomenclatureType = NomenclatureType::firstWhere('name', $details->nomenclatureType);
                            if (!$nomenclatureType) {
                                $nomenclatureType = $this->createNomenclatureTypeAction->exec(CreateNomenclatureTypeData::from([
                                    'name' => $details->nomenclatureType,
                                    'user_id' => Auth::id(),
                                ]));
                            }

                            /** @var Nomenclature $nomenclature */
                            $nomenclature = Nomenclature::firstWhere('name', $details->nomenclatureName);
                            if (!$nomenclature) {
                                $nomenclature = $this->createNomenclatureAction->exec(CreateNomenclatureData::from([
                                    'name' => $details->nomenclatureName,
                                    'user_id' => Auth::id(),
                                    'nomenclature_type_id' => $nomenclatureType->id,
                                ]));
                            }

                            return DetailsData::from([
                                'count' => $details->count,
                                'cost' => $details->cost,
                                'nomenclature_id' => $nomenclature->id,
                            ]);
                        })
                ]));
            });
        });
    }
}
