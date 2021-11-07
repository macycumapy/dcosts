<?php

namespace App\Http\Controllers;

use App\Http\Requests\CostItem\CostItemOwnerRequest;
use App\Http\Requests\CostItem\CostItemStoreRequest;
use App\Http\Requests\CostItem\CostItemUpdateRequest;
use App\Models\CostItem;
use App\Repositories\CostItemRepository;
use Illuminate\Http\JsonResponse;

class CostItemController extends Controller
{
    protected CostItemRepository $repository;

    /**
     * @param CostItemRepository $repository
     */
    public function __construct(CostItemRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $result = $this->repository->all(['user_id' => auth()->id()]);

        return $this->successResponse('Список получен', $result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CostItemStoreRequest $request
     * @return JsonResponse
     */
    public function store(CostItemStoreRequest $request): JsonResponse
    {
        $costItem = $this->repository->create($request->validated());

        return $this->successResponse('Статья затрат добавлена', $costItem);
    }

    /**
     * Display the specified resource.
     *
     * @param CostItemOwnerRequest $request
     * @param CostItem $costItem
     * @return JsonResponse
     */
    public function show(CostItemOwnerRequest $request, CostItem $costItem): JsonResponse
    {
        return $this->successResponse('Статья затрат получена', $costItem);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CostItemUpdateRequest $request
     * @param CostItem $costItem
     * @return JsonResponse
     */
    public function update(CostItemUpdateRequest $request, CostItem $costItem): JsonResponse
    {
        $costItem->update($request->validated());

        return $this->successResponse('Статья затрат обновлена', $costItem);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param CostItemOwnerRequest $request
     * @param CostItem $costItem
     * @return JsonResponse
     */
    public function destroy(CostItemOwnerRequest $request, CostItem $costItem): JsonResponse
    {
        $costItem->delete();

        return $this->successResponse('Статья затрат удалена');
    }
}
