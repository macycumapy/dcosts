<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Report\OutflowsRequest;
use App\Services\ReportService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;

class ReportController extends Controller
{
    /**
     * @param OutflowsRequest $request
     * @return JsonResponse
     */
    public function getOutflows(OutflowsRequest $request): JsonResponse
    {
        $report = ReportService::make(auth()->user());
        $reportData = $report->getOutflows(Carbon::parse($request->date_from), Carbon::parse($request->date_to));

        return $this->successResponse('Данные получены', $reportData);
    }
}
