<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Documents\CashFlowInterface;
use App\Models\ModelInterface;
use Illuminate\Http\Request;

class CashFlowController extends Controller
{
    private $cashFlow;

    public function __construct(CashFlowInterface $cashFlow)
    {
        $this->cashFlow = $cashFlow;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $result = $this->cashFlow->all();

        return response()->json($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $attr = $request->validate($this->cashFlow->rules());

        $newCashFlow = $this->cashFlow->tryToCreate($attr);
        if ($details = isset($attr['details']) ? $attr['details'] : null) {
            foreach ($details as $detail){
                $newCashFlow->addDetails($detail);
            }
        }

        return response()->json($newCashFlow->firstWithDetails());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $cashFlow = $this->findByIdOrAbort($this->cashFlow, $id);

        return response()->json($cashFlow->firstWithDetails());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $attr = $request->validate($this->cashFlow->rules());

        $cashFlow = $this->findByIdOrAbort($this->cashFlow,$id);
        $cashFlow->tryToUpdate($attr);

        return response()->json($cashFlow->firstWithDetails());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $cashFlow = $this->findByIdOrAbort($this->cashFlow, $id);
        $cashFlow->tryToDelete();

        return response()->json([]);
    }

    /**
     * Finding model by id
     *
     * @param CashFlowInterface $cashFlow
     * @param $id
     * @return CashFlowInterface|CashFlowInterface[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    private function findByIdOrAbort(CashFlowInterface $cashFlow, $id)
    {
        $cashFlow = $cashFlow->findById($id);
        if (!$cashFlow) abort(response()->json([],404));

        return $cashFlow;
    }
}
