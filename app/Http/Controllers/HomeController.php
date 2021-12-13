<?php

namespace App\Http\Controllers;

use App\Services\StatisticService;
use Illuminate\Http\JsonResponse;

class HomeController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function getBalance(): JsonResponse
    {
        $statistics = StatisticService::make(auth()->user());

        return $this->successResponse('Текущий баланс', $statistics->getBalance());
    }
}
