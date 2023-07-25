<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\CostItems\CreateCostItemAction;
use App\Actions\CostItems\DeleteCostItemAction;
use App\Actions\CostItems\UpdateCostItemAction;
use App\Http\Requests\CostItem\CostItemStoreRequest;
use App\Http\Requests\CostItem\CostItemUpdateRequest;
use App\Models\CostItem;
use Illuminate\Http\JsonResponse;

class CostItemController extends Controller
{
    public function index(): JsonResponse
    {
        return $this->successResponse('Список получен', CostItem::all());
    }

    public function store(CostItemStoreRequest $request, CreateCostItemAction $createCostItemAction): JsonResponse
    {
        return $this->successResponse(
            'Статья затрат добавлена',
            $createCostItemAction->exec($request->validated())
        );
    }

    public function show(CostItem $costItem): JsonResponse
    {
        return $this->successResponse(
            'Статья затрат получена',
            $costItem
        );
    }

    public function update(CostItemUpdateRequest $request, CostItem $costItem, UpdateCostItemAction $updateCostItemAction): JsonResponse
    {
        return $this->successResponse(
            'Статья затрат обновлена',
            $updateCostItemAction->exec($costItem, $request->validated())
        );
    }

    public function destroy(CostItem $costItem, DeleteCostItemAction $deleteCostItemAction): JsonResponse
    {
        $deleteCostItemAction->exec($costItem);

        return $this->successResponse('Статья затрат удалена');
    }
}
