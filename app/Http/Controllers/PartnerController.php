<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Partner\PartnerOwnerRequest;
use App\Http\Requests\Partner\PartnerStoreRequest;
use App\Http\Requests\Partner\PartnerUpdateRequest;
use App\Models\Partner;
use App\Repositories\PartnerRepository;
use Illuminate\Http\JsonResponse;

class PartnerController extends Controller
{
    protected PartnerRepository $repository;

    /**
     * @param PartnerRepository $repository
     */
    public function __construct(PartnerRepository $repository)
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
     * @param PartnerStoreRequest $request
     * @return JsonResponse
     */
    public function store(PartnerStoreRequest $request): JsonResponse
    {
        $partner = $this->repository->create($request->validated());

        return $this->successResponse('Контрагент добавлен', $partner);
    }

    /**
     * Display the specified resource.
     *
     * @param PartnerOwnerRequest $request
     * @param Partner $partner
     * @return JsonResponse
     */
    public function show(PartnerOwnerRequest $request, Partner $partner): JsonResponse
    {
        return $this->successResponse('Контрагент получен', $partner);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PartnerUpdateRequest $request
     * @param Partner $partner
     * @return JsonResponse
     */
    public function update(PartnerUpdateRequest $request, Partner $partner): JsonResponse
    {
        $partner->update($request->validated());

        return $this->successResponse('Контрагент обновлен', $partner);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param PartnerOwnerRequest $request
     * @param Partner $partner
     * @return JsonResponse
     */
    public function destroy(PartnerOwnerRequest $request, Partner $partner): JsonResponse
    {
        $partner->delete();
        return $this->successResponse('Контрагент удален');
    }
}
