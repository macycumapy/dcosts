<?php

namespace App\Http\Controllers;

use App\Http\Requests\CashInflow\CashInflowOwnerRequest;
use App\Http\Requests\CashInflow\CashInflowStoreRequest;
use App\Http\Requests\CashInflow\CashInflowUpdateRequest;
use App\Models\CashInflow;
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
        $result = $this->repository->all(['user_id' => auth()->id()]);

        return $this->successResponse('Список получен', $result);
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

        return $this->successResponse('Номенклатура добавлена', $cashInflow);
    }

    /**
     * Display the specified resource.
     *
     * @param CashInflowOwnerRequest $request
     * @param CashInflow $cashInflow
     * @return JsonResponse
     */
    public function show(CashInflowOwnerRequest $request, CashInflow $cashInflow): JsonResponse
    {
        return $this->successResponse('Номенклатура получена', $cashInflow);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CashInflowUpdateRequest $request
     * @param CashInflow $cashInflow
     * @return JsonResponse
     */
    public function update(CashInflowUpdateRequest $request, CashInflow $cashInflow): JsonResponse
    {
        $cashInflow->update($request->validated());

        return $this->successResponse('Номенклатура обновлена', $cashInflow);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param CashInflowOwnerRequest $request
     * @param CashInflow $cashInflow
     * @return JsonResponse
     */
    public function destroy(CashInflowOwnerRequest $request, CashInflow $cashInflow): JsonResponse
    {
        $cashInflow->delete();

        return $this->successResponse('Номенклатура удалена');
    }
}
