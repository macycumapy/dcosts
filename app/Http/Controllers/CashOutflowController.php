<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CashFlow\CashFlowOwnerRequest;
use App\Http\Requests\CashFlow\CashOutflowStoreRequest;
use App\Http\Requests\CashFlow\CashOutflowUpdateRequest;
use App\Http\Resources\CashFlowPaginatorResource;
use App\Http\Resources\CashOutflowResource;
use App\Models\CashFlow;
use App\Repositories\CashOutflowRepository;
use Illuminate\Http\JsonResponse;

class CashOutflowController extends Controller
{
    protected CashOutflowRepository $repository;

    /**
     * @param CashOutflowRepository $repository
     */
    public function __construct(CashOutflowRepository $repository)
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
     * @param CashOutflowStoreRequest $request
     * @return JsonResponse
     */
    public function store(CashOutflowStoreRequest $request): JsonResponse
    {
        $cashOutflow = $this->repository->create($request->validated());

        return $this->successResponse('Расход добавлен', CashOutflowResource::make($cashOutflow));
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
        return $this->successResponse('Расход получен', CashOutflowResource::make($cashFlow));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CashOutflowUpdateRequest $request
     * @param CashFlow $cashFlow
     * @return JsonResponse
     * @throws \Exception
     */
    public function update(CashOutflowUpdateRequest $request, CashFlow $cashFlow): JsonResponse
    {
        $this->repository->update($cashFlow->id, $request->validated());

        return $this->successResponse('Расход обновлен', CashOutflowResource::make($cashFlow));
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

        return $this->successResponse('Расход удален');
    }
}
