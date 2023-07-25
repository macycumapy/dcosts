<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\CashFlowPaginatorResource;
use App\Models\CashFlow;
use Illuminate\Http\JsonResponse;

class CashFlowController extends Controller
{
    public function index(): JsonResponse
    {
        return $this->successResponse(
            'Список получен',
            CashFlowPaginatorResource::make(CashFlow::paginate())
        );
    }
}
