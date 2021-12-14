<?php

namespace App\Http\Controllers;

use App\Http\Requests\CashFlow\CashFlowOwnerRequest;
use App\Http\Requests\CashFlow\CashInflowStoreRequest;
use App\Http\Requests\CashFlow\CashInflowUpdateRequest;
use App\Http\Resources\CashFlowPaginatorResource;
use App\Models\CashFlow;
use App\Repositories\CashInflowRepository;
use Illuminate\Http\JsonResponse;

class CashInflowController extends Controller
{
    protected CashInflowRepository $repository;

    /**
     * @param CashInflowRepository $repository
     */
    public function __construct(CashInflowRepository $repository)
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
        $paginatedList = $this->repository->paginate(['user_id' => auth()->id()]);
        return $this->successResponse('Список получен', CashFlowPaginatorResource::make($paginatedList));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CashInflowStoreRequest $request
     * @return JsonResponse
     */
    public function store(CashInflowStoreRequest $request): JsonResponse
    {
        $cashInflow = $this->repository->create($request->validated());

        return $this->successResponse('Поступление добавлено', $cashInflow);
    }

    /**
     * Display the specified resource.
     *
     * @param CashFlowOwnerRequest $request
     * @param CashFlow $cashFlow
     * @return JsonResponse
     */
    public function show(CashFlowOwnerRequest $request, CashFlow $cashFlow): JsonResponse
    {
        return $this->successResponse('Поступление получено', $cashFlow);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CashInflowUpdateRequest $request
     * @param CashFlow $cashFlow
     * @return JsonResponse
     */
    public function update(CashInflowUpdateRequest $request, CashFlow $cashFlow): JsonResponse
    {
        $cashFlow->update($request->validated());

        return $this->successResponse('Поступление обновлено', $cashFlow);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param CashFlowOwnerRequest $request
     * @param CashFlow $cashFlow
     * @return JsonResponse
     */
    public function destroy(CashFlowOwnerRequest $request, CashFlow $cashFlow): JsonResponse
    {
        $cashFlow->delete();

        return $this->successResponse('Поступление удалено');
    }
}
