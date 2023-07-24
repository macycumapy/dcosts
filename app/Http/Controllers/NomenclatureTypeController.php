<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\NomenclatureTypes\CreateNomenclatureTypeAction;
use App\Actions\NomenclatureTypes\DeleteNomenclatureTypeAction;
use App\Actions\NomenclatureTypes\UpdateNomenclatureTypeAction;
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

    public function index(): JsonResponse
    {
        return $this->successResponse(
            'Список получен',
            NomenclatureType::all()
        );
    }

    public function store(NomenclatureTypeStoreRequest $request, CreateNomenclatureTypeAction $action): JsonResponse
    {
        return $this->successResponse(
            'Тип номенклатуры добавлен',
            $action->exec($request->validated())
        );
    }

    public function show(NomenclatureType $nomenclatureType): JsonResponse
    {
        return $this->successResponse(
            'Тип номенклатуры получен',
            $nomenclatureType
        );
    }

    public function update(NomenclatureTypeUpdateRequest $request, NomenclatureType $nomenclatureType, UpdateNomenclatureTypeAction $action): JsonResponse
    {
        return $this->successResponse(
            'Тип номенклатуры обновлен',
            $action->exec($nomenclatureType, $request->validated())
        );
    }

    public function destroy(NomenclatureType $nomenclatureType, DeleteNomenclatureTypeAction $action): JsonResponse
    {
        $action->exec($nomenclatureType);

        return $this->successResponse('Тип номенклатуры удален');
    }
}
