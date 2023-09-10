<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\CashFlow\CreateCashFlowAction;
use App\Actions\CashFlow\DeleteCashFlowAction;
use App\Actions\CashFlow\UpdateCashFlowAction;
use App\Http\Requests\CashFlow\CashInflowStoreRequest;
use App\Http\Requests\CashFlow\CashInflowUpdateRequest;
use App\Http\Resources\CashFlowPaginatorResource;
use App\Models\CashFlow;
use Illuminate\Http\JsonResponse;

class CashInflowController extends Controller
{
    public function index(): JsonResponse
    {
        return $this->successResponse(
            'Список получен',
            CashFlowPaginatorResource::make(CashFlow::inflows()->paginate())
        );
    }

    public function store(CashInflowStoreRequest $request, CreateCashFlowAction $createCashFlowAction): JsonResponse
    {
        return $this->successResponse(
            'Поступление добавлено',
            $createCashFlowAction->exec($request->validated())
        );
    }

    public function show(int $id): JsonResponse
    {
        return $this->successResponse(
            'Поступление получено',
            CashFlow::inflows()->findOrFail($id)
        );
    }

    public function update(CashInflowUpdateRequest $request, int $id, UpdateCashFlowAction $updateCashFlowAction): JsonResponse
    {
        /** @var CashFlow $cashFlow */
        $cashFlow = CashFlow::inflows()->findOrFail($id);

        return $this->successResponse(
            'Поступление обновлено',
            $updateCashFlowAction->exec($cashFlow, $request->validated())
        );
    }

    public function destroy(int $id, DeleteCashFlowAction $deleteCashFlowAction): JsonResponse
    {
        /** @var CashFlow $cashFlow */
        $cashFlow = CashFlow::inflows()->findOrFail($id);

        $deleteCashFlowAction->exec($cashFlow);

        return $this->successResponse('Поступление удалено');
    }
}
