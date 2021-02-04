<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CashFlowRequest;
use App\Http\Resources\CashFlowResource;
use App\Models\Documents\CashFlow;

class CashFlowController extends Controller
{
    private CashFlow $cashFlow;

    public function __construct(CashFlow $cashFlow)
    {
        $this->cashFlow = $cashFlow;
        $this->cashFlow->whereAuthUserOwner();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $result = $this->cashFlow->all();

        return response()->json(CashFlowResource::collection($result));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CashFlowRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CashFlowRequest $request)
    {
        $attr = $request->validated();
        $newCashFlow = $this->cashFlow->create($attr);

        if (isset($attr['details'])) {
            foreach ($attr['details'] as $detail){
                unset($detail['id']);
                $newCashFlow->addDetails($detail);
            }
        }

        return response()->json(CashFlowResource::make($newCashFlow));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $cashFlow = $this->cashFlow->findOrFail($id);

        return response()->json(CashFlowResource::make($cashFlow));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CashFlowRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CashFlowRequest $request, $id)
    {
        $attr = $request->validated();

        $cashFlow = $this->cashFlow->findOrFail($id);

        $details = isset($attr['details']) ? $attr['details'] : null;
        $attr['sum'] = $this->cashFlow::getSumByDetails($details);

        $cashFlow->update($attr);
        if ($details) {
            $cashFlow->updateDetails($details);
        }

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
        $cashFlow = $this->cashFlow->findOrFail($id);
        $cashFlow->delete();

        return response()->json([]);
    }
}
