<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Partner\CreatePartnerAction;
use App\Actions\Partner\DeletePartnerAction;
use App\Actions\Partner\UpdatePartnerAction;
use App\Http\Requests\Partner\PartnerStoreRequest;
use App\Http\Requests\Partner\PartnerUpdateRequest;
use App\Models\Partner;
use Illuminate\Http\JsonResponse;

class PartnerController extends Controller
{
    public function index(): JsonResponse
    {
        return $this->successResponse('Список получен', Partner::all());
    }

    public function store(PartnerStoreRequest $request, CreatePartnerAction $createPartnerAction): JsonResponse
    {
        return $this->successResponse(
            'Контрагент добавлен',
            $createPartnerAction->exec($request->validated())
        );
    }

    public function show(Partner $partner): JsonResponse
    {
        return $this->successResponse('Контрагент получен', $partner);
    }

    public function update(PartnerUpdateRequest $request, Partner $partner, UpdatePartnerAction $updatePartnerAction): JsonResponse
    {
        return $this->successResponse(
            'Контрагент обновлен',
            $updatePartnerAction->exec($partner, $request->validated())
        );
    }

    public function destroy(Partner $partner, DeletePartnerAction $deletePartnerAction): JsonResponse
    {
        $deletePartnerAction->exec($partner);
        return $this->successResponse('Контрагент удален');
    }
}
