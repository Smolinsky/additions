<?php

namespace App\Http\Controllers\Api\Traits;

use Illuminate\Http\JsonResponse;

/**
 * Trait ResponseTrait
 * @package App\Api\Controllers\Traits
 */
trait ResponseTrait
{
    /**
     * @param $message
     * @param bool $key
     * @param int $status
     * @return JsonResponse
     */
    public function invalidate($message, $key = false, $status = 422): JsonResponse
    {
        $data = [
            'success' => false,
            'message' => $message,
        ];

        if ($key) {
            $data['errors'][$key] = $message;
        }

        return response()->json($data, $status);
    }

    /**
     * @param $message
     * @param $key
     * @return JsonResponse
     */
    public function invalidateField($message, $key): JsonResponse
    {
        $data['errors'][$key] = $message;

        return response()->json($data, JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @param $keys_messages
     * @return JsonResponse
     */
    public function invalidateFields($keys_messages): JsonResponse
    {
        $data = [];

        foreach ($keys_messages as $key => $message) {
            $data['errors'][$key] = $message;
        }

        return response()->json($data, JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @param $message
     * @param int $status
     * @return JsonResponse
     */
    public function success($message, $status = 200): JsonResponse
    {
        $data = [
            'success' => true,
            'message' => $message,
        ];

        return response()->json($data, $status);
    }

    /**
     * @param string $message
     * @return JsonResponse
     */
    public function notFound(string $message = ''): JsonResponse
    {
        $message = $message ?: trans('messages.not found');

        return $this->invalidate($message, false, 404);
    }

    /**
     * @param string $message
     * @return JsonResponse
     */
    public function forbidden(string $message = ''): JsonResponse
    {
        $message = $message ?: trans('messages.access forbidden');

        return $this->invalidate($message, false, 403);
    }

    /**
     * @param int $count
     * @return array
     */
    public function metaTotal(int $count): array
    {
        return [
            'meta' => [
                'total' => $count
            ]
        ];
    }
}
