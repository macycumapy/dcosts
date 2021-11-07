<?php

namespace App\Http\Controllers;

use App\Http\Requests\Nomenclature\NomenclatureOwnerRequest;
use App\Http\Requests\Nomenclature\NomenclatureStoreRequest;
use App\Http\Requests\Nomenclature\NomenclatureUpdateRequest;
use App\Models\Nomenclature;
use App\Repositories\NomenclatureRepository;
use Illuminate\Http\JsonResponse;

class NomenclatureController extends Controller
{
    protected NomenclatureRepository $repository;

    /**
     * @param NomenclatureRepository $repository
     */
    public function __construct(NomenclatureRepository $repository)
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
     * @param NomenclatureStoreRequest $request
     * @return JsonResponse
     */
    public function store(NomenclatureStoreRequest $request): JsonResponse
    {
        $nomenclature = $this->repository->create($request->validated());

        return $this->successResponse('Номенклатура добавлена', $nomenclature);
    }

    /**
     * Display the specified resource.
     *
     * @param NomenclatureOwnerRequest $request
     * @param Nomenclature $nomenclature
     * @return JsonResponse
     */
    public function show(NomenclatureOwnerRequest $request, Nomenclature $nomenclature): JsonResponse
    {
        return $this->successResponse('Номенклатура получена', $nomenclature);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param NomenclatureUpdateRequest $request
     * @param Nomenclature $nomenclature
     * @return JsonResponse
     */
    public function update(NomenclatureUpdateRequest $request, Nomenclature $nomenclature): JsonResponse
    {
        $nomenclature->update($request->validated());

        return $this->successResponse('Номенклатура обновлена', $nomenclature);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param NomenclatureOwnerRequest $request
     * @param Nomenclature $nomenclature
     * @return JsonResponse
     */
    public function destroy(NomenclatureOwnerRequest $request, Nomenclature $nomenclature): JsonResponse
    {
        $nomenclature->delete();

        return $this->successResponse('Номенклатура удалена');
    }
}
