<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CashInflowRequest;
use App\Http\Resources\CashInflowResource;
use App\Models\Documents\CashInflow;

class CashInflowController extends Controller
{
    protected CashInflow $cashInflow;

    public function __construct(CashInflow $cashInflow)
    {
        $this->cashInflow = $cashInflow;
        $this->cashInflow->whereAuthUserOwner();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $cashInflows = $this->cashInflow->allByAuthUser();

        return response()->json(CashInflowResource::collection($cashInflows));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CashInflowRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CashInflowRequest $request)
    {
        $cashInflow = $this->cashInflow->create($request->validated());

        return response()->json(CashInflowResource::make($cashInflow));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $cashInflow = $this->cashInflow->whereAuthUserOwner()->find($id);
        if (!$cashInflow) {
            return response()->json([],404);
        }

        return response()->json(CashInflowResource::make($cashInflow));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CashInflowRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CashInflowRequest $request, $id)
    {
        $cashInflow = $this->cashInflow->whereAuthUserOwner()->find($id);
        if (!$cashInflow) {
            return response()->json([],404);
        }

        $cashInflow->update($request->validated());

        return response()->json(CashInflowResource::make($cashInflow));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $cashInflow = $this->cashInflow->whereAuthUserOwner()->find($id);
        if (!$cashInflow) {
            return response()->json([],404);
        }
        $deleted = $cashInflow->delete();

        return response()->json([],$deleted ? 200 : 400);
    }
}
