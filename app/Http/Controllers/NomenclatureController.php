<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Nomenclatures\CreateNomenclatureAction;
use App\Actions\Nomenclatures\DeleteNomenclatureAction;
use App\Actions\Nomenclatures\UpdateNomenclatureAction;
use App\Http\Requests\Nomenclature\NomenclatureStoreRequest;
use App\Http\Requests\Nomenclature\NomenclatureUpdateRequest;
use App\Models\Nomenclature;
use Illuminate\Http\JsonResponse;

class NomenclatureController extends Controller
{
    public function index(): JsonResponse
    {
        return $this->successResponse(
            'Список получен',
            Nomenclature::all()
        );
    }

    public function store(NomenclatureStoreRequest $request, CreateNomenclatureAction $action): JsonResponse
    {
        return $this->successResponse(
            'Номенклатура добавлена',
            $action->exec($request->validated())
        );
    }

    public function show(Nomenclature $nomenclature): JsonResponse
    {
        return $this->successResponse(
            'Номенклатура получена',
            $nomenclature
        );
    }

    public function update(NomenclatureUpdateRequest $request, Nomenclature $nomenclature, UpdateNomenclatureAction $action): JsonResponse
    {
        return $this->successResponse(
            'Номенклатура обновлена',
            $action->exec($nomenclature, $request->validated())
        );
    }

    public function destroy(Nomenclature $nomenclature, DeleteNomenclatureAction $action): JsonResponse
    {
        $action->exec($nomenclature);

        return $this->successResponse('Номенклатура удалена');
    }
}
