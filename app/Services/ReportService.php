<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\CashFlowType;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ReportService
{
    /**
     * @param User $user
     */
    public function __construct(private User $user)
    {
    }

    /**
     * Создание нового экземпляра класса
     * @param User $user
     * @return static
     */
    public static function make(User $user): self
    {
        return app(self::class, ['user' => $user]);
    }

    /**
     * @param Carbon $dateFrom
     * @param Carbon $dateTo
     * @return Collection
     */
    public function getOutflows(Carbon $dateFrom, Carbon $dateTo): Collection
    {
        $groupedData = DB::table('cash_outflow_details as cod')
            ->select(
                DB::raw('sum(round(cod.count::numeric * cod.cost::numeric, 2)) as sum'),
                DB::raw('COALESCE(ci.name, \'Прочее\') as category'),
                DB::raw('COALESCE(nt.name, \'Прочее\') as nomenclature_type'),
                'n.name as nomenclature',
            )
            ->leftJoin('nomenclatures as n', 'n.id', '=', 'cod.nomenclature_id')
            ->leftJoin('cash_flows as cf', 'cf.id', '=', 'cod.cash_outflow_id')
            ->leftJoin('cost_items as ci', 'ci.id', '=', 'cf.cost_item_id')
            ->leftJoin('nomenclature_types as nt', 'nt.id', '=', 'n.nomenclature_type_id')
            ->whereBetween('cf.date', [$dateFrom, $dateTo->endOfDay()])
            ->where('cf.type', CashFlowType::Outflow->value)
            ->where('cf.user_id', $this->user->id)
            ->groupBy('category', 'nomenclature', 'nomenclature_type')
            ->orderByDesc('sum')
            ->get()
            ->groupBy(['category', fn ($item) => $item->nomenclature_type]);

        return $this->compareWithSum($groupedData);
    }

    /**
     * @param Collection $collection
     * @return Collection
     */
    private function compareWithSum(Collection $collection): Collection
    {
        return $collection->map(function ($item, $key) {
            if ($item instanceof Collection) {
                $details = $this->compareWithSum($item);

                return [
                    'name' => $key,
                    'details' => $details,
                    'sum' => $details->sum('sum'),
                ];
            }

            return $item;
        })->sortByDesc('sum')->values();
    }
}
