<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\NomenclatureType\NomenclatureTypeOwnerRequest;
use App\Http\Requests\NomenclatureType\NomenclatureTypeStoreRequest;
use App\Http\Requests\NomenclatureType\NomenclatureTypeUpdateRequest;
use App\Models\NomenclatureType;
use App\Repositories\NomenclatureTypeRepository;
use Illuminate\Http\JsonResponse;

class NomenclatureTypeController extends Controller
{
    protected NomenclatureTypeRepository $repository;

    /**
     * @param NomenclatureTypeRepository $repository
     */
    public function __construct(NomenclatureTypeRepository $repository)
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
     * @param NomenclatureTypeStoreRequest $request
     * @return JsonResponse
     */
    public function store(NomenclatureTypeStoreRequest $request): JsonResponse
    {
        $nomenclatureType = $this->repository->create($request->validated());

        return $this->successResponse('Тип номенклатуры добавлен', $nomenclatureType);
    }

    /**
     * Display the specified resource.
     *
     * @param NomenclatureTypeOwnerRequest $request
     * @param NomenclatureType $nomenclatureType
     * @return JsonResponse
     */
    public function show(NomenclatureTypeOwnerRequest $request, NomenclatureType $nomenclatureType): JsonResponse
    {
        return $this->successResponse('Тип номенклатуры получен', $nomenclatureType);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param NomenclatureTypeUpdateRequest $request
     * @param NomenclatureType $nomenclatureType
     * @return JsonResponse
     */
    public function update(NomenclatureTypeUpdateRequest $request, NomenclatureType $nomenclatureType): JsonResponse
    {
        $nomenclatureType->update($request->validated());

        return $this->successResponse('Тип номенклатуры обновлен', $nomenclatureType);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param NomenclatureTypeOwnerRequest $request
     * @param NomenclatureType $nomenclatureType
     * @return JsonResponse
     */
    public function destroy(NomenclatureTypeOwnerRequest $request, NomenclatureType $nomenclatureType): JsonResponse
    {
        $nomenclatureType->delete();
        return $this->successResponse('Тип номенклатуры удален');
    }
}
