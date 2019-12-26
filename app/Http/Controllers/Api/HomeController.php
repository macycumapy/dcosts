<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Documents\CashFlowInterface;
use App\Models\Documents\CashInflowInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    protected $cashFlow;
    protected $cashInflow;
    protected $db;

    public function __construct(CashFlowInterface $cashFlow, CashInflowInterface $cashInflow, DB $db)
    {
        $this->cashFlow = $cashFlow;
        $this->cashInflow = $cashInflow;
        $this->db = $db;
    }

    /**
     * Getting total cash balance
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function balance()
    {
        $cashFlows = $this->cashFlow
            ->select('user_id', $this->db::raw('SUM(sum) * -1 as sum'))
            ->where('user_id', auth()->id())
            ->groupBy('user_id');

        $sum = $this->cashInflow
            ->select('user_id', $this->db::raw('SUM(sum) as sum'))
            ->where('user_id', auth()->id())
            ->groupBy('user_id')
            ->union($cashFlows)
            ->sum('sum');

        return response()->json(['sum' => $sum]);
    }

    /**
     * Getting total list of cash flow & inflow
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function cashList()
    {
        $cashFlows = $this->cashFlow
            ->leftJoin('cost_items', 'cash_flows.cost_item_id', '=', 'cost_items.id')
            ->with('details')
            ->select(
                'cash_flows.id',
                'cash_flows.date',
                'cash_flows.user_id',
                'cash_flows.sum',
                'cash_flows.cost_item_id',
                $this->db::raw('cost_items.name as cost_item'),
                $this->db::raw('null as partner_id'),
                $this->db::raw('true as is_flow'))
            ->where('cash_flows.user_id', auth()->id())
            ->groupBy('id', 'is_flow');

        $cashInflows = $this->cashInflow
            ->leftJoin('cost_items', 'cash_inflows.cost_item_id', '=', 'cost_items.id')
            ->select(
                'cash_inflows.id',
                'cash_inflows.date',
                'cash_inflows.user_id',
                'cash_inflows.sum',
                'cash_inflows.cost_item_id',
                $this->db::raw('cost_items.name as cost_item'),
                'cash_inflows.partner_id',
                $this->db::raw('false as is_flow'))
            ->where('cash_inflows.user_id', auth()->id())
            ->groupBy('id', 'is_flow');

        $totalList = $cashFlows
            ->union($cashInflows)
            ->orderBy('date')
            ->orderBy('id')
            ->get();

        return response()->json($totalList);
    }
}
