<?php

declare(strict_types=1);

use Illuminate\Http\JsonResponse;

if (!function_exists('make_response')) {
    /**
     * JSON ответ на API запрос
     *
     * @param int $status Статус ответа
     * @param string $message Сообщение о результате обращения
     * @param mixed $data Данные полученные в результате обращения
     * @param array|null $errors Список ошибок, возникших во время обращения
     *
     * @return JsonResponse
     */
    function make_response(string $message = '', int $status = 200, $data = null, array $errors = null): JsonResponse
    {
        $responseData = [
            'message' => $message
        ];

        /**
         * Добавляем блок данных только при их наличии
         */
        if (!empty($data)) {
            $responseData['data'] = $data;
        }

        /**
         * Добавляем блок ошибок только при их наличии
         */
        if (!empty($errors)) {
            $responseData['errors'] = $errors;
        }

        return response()->json(
            $responseData,
            $status,
            [
                'Content-Type' => 'application/json;charset=UTF-8',
                'Charset' => 'utf-8'
            ],
            JSON_UNESCAPED_UNICODE
        );
    }
}
