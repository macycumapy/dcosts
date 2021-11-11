<?php

namespace App\Http\Controllers;

use App\Http\Requests\CashOutflow\CashOutflowOwnerRequest;
use App\Http\Requests\CashOutflow\CashOutflowStoreRequest;
use App\Http\Requests\CashOutflow\CashOutflowUpdateRequest;
use App\Http\Resources\CashOutflowResource;
use App\Models\CashOutflow;
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
        $result = $this->repository->paginate(['user_id' => auth()->id()]);
        return $this->successResponse('Список получен', [
            'data' => CashOutflowResource::collection($result),
            'pages' => $result->lastPage(),
            'page' => $result->currentPage(),
        ]);
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
     * @param CashOutflowOwnerRequest $request
     * @param CashOutflow $cashOutflow
     * @return JsonResponse
     */
    public function show(CashOutflowOwnerRequest $request, CashOutflow $cashOutflow): JsonResponse
    {
        return $this->successResponse('Расход получен', CashOutflowResource::make($cashOutflow));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CashOutflowUpdateRequest $request
     * @param CashOutflow $cashOutflow
     * @return JsonResponse
     * @throws \Exception
     */
    public function update(CashOutflowUpdateRequest $request, CashOutflow $cashOutflow): JsonResponse
    {
        $this->repository->update($cashOutflow->id, $request->validated());

        return $this->successResponse('Расход обновлен', CashOutflowResource::make($cashOutflow));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param CashOutflowOwnerRequest $request
     * @param CashOutflow $cashOutflow
     * @return JsonResponse
     */
    public function destroy(CashOutflowOwnerRequest $request, CashOutflow $cashOutflow): JsonResponse
    {
        $cashOutflow->delete();

        return $this->successResponse('Расход удален');
    }
}
