<?php

namespace App\Providers;

use App\Models\Dictionaries\CostItem;
use App\Models\Dictionaries\CostItemInterface;
use App\Models\Dictionaries\Partner;
use App\Models\Documents\CashFlow;
use App\Models\Documents\CashFlowDetails;
use App\Models\Documents\CashFlowDetailsInterface;
use App\Models\Documents\CashFlowInterface;
use App\Models\Documents\CashInflow;
use App\Models\Documents\CashInflowInterface;
use App\Models\Dictionaries\NomenclatureInterface;
use App\Models\Dictionaries\NomenclatureTypeInterface;
use App\Models\Dictionaries\Nomenclature;
use App\Models\Dictionaries\NomenclatureType;
use App\Models\Dictionaries\PartnerInterface;
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
        $this->app->bind(CashInflowInterface::class, CashInflow::class);
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
