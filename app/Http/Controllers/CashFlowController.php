<?php

namespace App\Http\Controllers;

use App\Services\CashFlowService;
use Illuminate\Http\JsonResponse;

class CashFlowController extends Controller
{
    /**
     * @param CashFlowService $cashFlow
     */
    public function __construct(private CashFlowService $cashFlow)
    {
    }

    /**
     * @return JsonResponse
     */
    public function getBalance(): JsonResponse
    {
        return $this->successResponse('Текущий баланс', $this->cashFlow->getBalance());
    }
}
