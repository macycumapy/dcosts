<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CostItemRequest;
use App\Models\Dictionaries\CostItem;

class CostItemController extends Controller
{
    private CostItem $costItem;

    public function __construct(CostItem $costItem)
    {
        $this->costItem = $costItem;
        $this->costItem->whereAuthUserOwner();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $result = $this->costItem->allByAuthUser();

        return response()->json($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CostItemRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CostItemRequest $request)
    {
        $costItem = $this->costItem->create($request->validated());

        return response()->json($costItem);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $costItem = $this->costItem->whereAuthUserOwner()->find($id);
        if (!$costItem) {
            return response()->json([],404);
        }

        return response()->json($costItem);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CostItemRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CostItemRequest $request, $id)
    {
        $costItem = $this->costItem->whereAuthUserOwner()->find($id);
        if (!$costItem) {
            return response()->json([],404);
        }

        $costItem->update($request->validated());

        return response()->json($costItem);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $costItem = $this->costItem->whereAuthUserOwner()->find($id);
        if (!$costItem) {
            return response()->json([],404);
        }
        $deleted = $costItem->delete();

        return response()->json([],$deleted ? 200 : 400);
    }
}
