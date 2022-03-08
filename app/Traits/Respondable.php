<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Throwable;

trait Respondable
{
    /**
     * @param null|mixed $data
     * @param string $message
     * @param int $statusCode
     * @return JsonResponse
     */
    public function success(
        $data = null,
        string $message = 'Successful',
        int $statusCode = Response::HTTP_OK
    ): JsonResponse {
        $response = [
            'success' => true,
            'message' => $message,
            'data' => $data,
        ];

        return response()->json($response, $statusCode);
    }

    /**
     * @param array|null $data
     * @param string $message
     * @param int $statusCode
     * @return JsonResponse
     */
    public function error(
        array $data = null,
        $message = 'Unsuccessful',
        $statusCode = Response::HTTP_BAD_REQUEST
    ): JsonResponse {
        $response = [
            'success' => false,
            'message' => $message,
            'errors' => $data,
        ];

        return response()->json($response, $statusCode);
    }

    /**
     * @param Throwable $e
     * @param int $statusCode
     * @return JsonResponse
     */
    public function fatalError(
        Throwable $e,
        int $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR
    ): JsonResponse {
        $trace = [
            'file' => $e->getFile(),
            'trace' => $e->getTrace()[0],
            'mini_trace' => $e->getTrace()[1],
            'time' => \Carbon\Carbon::now()->toDayDateTimeString(),
        ];

        if ('PRODUCTION' === strtoupper(config('APP_ENV'))) {
            $trace = [];
        }

        $response = [
            'success' => false,
            'message' => 'Oops! Something went wrong on the server',
            'detail' => $e->getMessage(),
            'trace' => $trace,
        ];

        return response()->json($response, $statusCode);
    }
}
