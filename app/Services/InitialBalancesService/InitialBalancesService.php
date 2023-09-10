<?php

declare(strict_types=1);

namespace App\Services\InitialBalancesService;

use App\Actions\CashFlow\CreateCashFlowAction;
use App\Actions\CashFlow\CreateCashOutflowAction;
use App\Actions\CashFlow\Data\CreateCashFlowData;
use App\Actions\CashFlow\Data\CreateCashOutflowData;
use App\Actions\CashOutflowDetail\Data\DetailsData;
use App\Actions\Category\CreateCategoryAction;
use App\Actions\Category\Data\CreateCategoryData;
use App\Actions\Nomenclature\CreateNomenclatureAction;
use App\Actions\Nomenclature\Data\CreateNomenclatureData;
use App\Actions\NomenclatureType\CreateNomenclatureTypeAction;
use App\Actions\NomenclatureType\Data\CreateNomenclatureTypeData;
use App\Actions\Partner\CreatePartnerAction;
use App\Actions\Partner\Data\CreatePartnerData;
use App\Enums\CashFlowType;
use App\Models\Category;
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
        private readonly CreatePartnerAction          $createPartnerAction,
        private readonly CreateCategoryAction         $createCategoryAction,
        private readonly CreateCashFlowAction         $createCashFlowAction,
        private readonly CreateCashOutflowAction      $createCashOutflowAction,
        private readonly CreateNomenclatureAction     $createNomenclatureAction,
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

                /** @var Category $category */
                $category = Category::firstWhere('name', $inflow->categoryName);
                if (!$category) {
                    $category = $this->createCategoryAction->exec(CreateCategoryData::from([
                        'name' => $inflow->categoryName,
                        'type' => CashFlowType::Inflow,
                        'user_id' => Auth::id(),
                    ]));
                }

                return $this->createCashFlowAction->exec(CreateCashFlowData::from([
                    'user_id' => Auth::id(),
                    'partner_id' => $partner->id,
                    'category_id' => $category->id,
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
                /** @var Category $category */
                $category = Category::firstWhere('name', $outflow->categoryName);
                if (!$category) {
                    $category = $this->createCategoryAction->exec(CreateCategoryData::from([
                        'name' => $outflow->categoryName,
                        'type' => CashFlowType::Outflow,
                        'user_id' => Auth::id(),
                    ]));
                }

                return $this->createCashOutflowAction->exec(CreateCashOutflowData::from([
                    'user_id' => Auth::id(),
                    'category_id' => $category->id,
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
