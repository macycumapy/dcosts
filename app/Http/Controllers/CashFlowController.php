<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\CashFlowPaginatorResource;
use App\Repositories\CashFlowRepository;
use Illuminate\Http\JsonResponse;

class CashFlowController extends Controller
{
    /**
     * @param CashFlowRepository $repository
     */
    public function __construct(private CashFlowRepository $repository)
    {
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $paginatedList = $this->repository->paginate(['user_id' => auth()->id()]);

        return $this->successResponse('Список получен', CashFlowPaginatorResource::make($paginatedList));
    }
}
