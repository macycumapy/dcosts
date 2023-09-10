<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\CashFlows\CreateCashOutflowAction;
use App\Actions\CashFlows\DeleteCashFlowAction;
use App\Actions\CashFlows\UpdateCashOutflowAction;
use App\Http\Requests\CashFlow\CashOutflowStoreRequest;
use App\Http\Requests\CashFlow\CashOutflowUpdateRequest;
use App\Http\Resources\CashFlowPaginatorResource;
use App\Http\Resources\CashOutflowResource;
use App\Models\CashFlow;
use Illuminate\Http\JsonResponse;

class CashOutflowController extends Controller
{
    public function index(): JsonResponse
    {
        return $this->successResponse('Список получен', CashFlowPaginatorResource::make(CashFlow::outflows()->paginate()));
    }

    public function store(CashOutflowStoreRequest $request, CreateCashOutflowAction $createCashOutflowAction): JsonResponse
    {
        return $this->successResponse(
            'Расход добавлен',
            CashOutflowResource::make($createCashOutflowAction->exec($request->validated())),
        );
    }

    public function show(int $id): JsonResponse
    {
        /** @var CashFlow $cashFlow */
        $cashFlow = CashFlow::outflows()->findOrFail($id);

        return $this->successResponse(
            'Расход получен',
            CashOutflowResource::make($cashFlow)
        );
    }

    public function update(CashOutflowUpdateRequest $request, int $id, UpdateCashOutflowAction $updateCashOutflowAction): JsonResponse
    {
        /** @var CashFlow $cashFlow */
        $cashFlow = CashFlow::outflows()->findOrFail($id);

        return $this->successResponse(
            'Расход обновлен',
            CashOutflowResource::make(
                $updateCashOutflowAction->exec($cashFlow, $request->validated())
            )
        );
    }

    public function destroy(int $id, DeleteCashFlowAction $deleteCashFlowAction): JsonResponse
    {
        /** @var CashFlow $cashFlow */
        $cashFlow = CashFlow::outflows()->findOrFail($id);
        $deleteCashFlowAction->exec($cashFlow);

        return $this->successResponse('Расход удален');
    }
}
