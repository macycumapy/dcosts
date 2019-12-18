<?php

namespace App\Providers;

use App\Models\CostItem;
use App\Models\CostItemInterface;
use App\Models\Dictionaries\Partner;
use App\Models\Documents\CashFlow;
use App\Models\Documents\CashFlowDetails;
use App\Models\Documents\CashFlowDetailsInterface;
use App\Models\Documents\CashFlowInterface;
use App\Models\NomenclatureInterface;
use App\Models\NomenclatureTypeInterface;
use App\Models\Nomenclature;
use App\Models\NomenclatureType;
use App\Models\PartnerInterface;
use function foo\func;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(NomenclatureInterface::class, Nomenclature::class);
        $this->app->bind(NomenclatureTypeInterface::class, NomenclatureType::class);
        $this->app->bind(CashFlowInterface::class, CashFlow::class);
        $this->app->bind(CashFlowDetailsInterface::class, CashFlowDetails::class);
        $this->app->bind(CostItemInterface::class, CostItem::class);
        $this->app->bind(PartnerInterface::class, Partner::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
