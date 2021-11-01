<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Execute an action on the controller.
     *
     * @param string $method
     * @param array  $parameters
     *
     * @return Response
     */
    public function callAction($method, $parameters)
    {
        try {
            return parent::callAction($method, $parameters);
        } catch (\Throwable $exception) {
            Log::error($exception);
            return make_response(500, 'Возникла внутренняя ошибка!');
        }
    }

    /**
     * @param string $message
     * @param null $data
     * @return JsonResponse
     */
    protected function successResponse(string $message = '', $data = null): JsonResponse
    {
        return make_response($message, 200, $data);
    }

    /**
     * @param string $message
     * @param null   $data
     * @param null   $errors
     *
     * @return JsonResponse
     */
    protected function failureResponse(string $message = '', $errors = null, $data = null): JsonResponse
    {
        return make_response($message, 400, $data, $errors);
    }

    /**
     * @param string $message
     * @param null   $data
     * @param null   $errors
     *
     * @return JsonResponse
     */
    protected function errorResponse(string $message = '', $errors = null, $data = null): JsonResponse
    {
        return make_response($message, 500, $data, $errors);
    }
}
