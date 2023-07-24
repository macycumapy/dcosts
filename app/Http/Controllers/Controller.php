<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

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
            return make_response('Возникла внутренняя ошибка!', 500);
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
