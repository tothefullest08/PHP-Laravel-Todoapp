<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class ResponseHandler
{
    /**
     * @param object $data
     * @param string $message
     * @param int $statusCode
     *
     * @return JsonResponse
     */
    public static function success(object $data, string $message = 'success', int $statusCode = 200)
    {
        return response()->json([
            'data'    => $data,
            'message' => $message,
        ], $statusCode);
    }

    /**
     * @param object $data
     * @param string $message
     *
     * @return JsonResponse
     */
    public static function notFound(object $data, string $message = 'Not Found')
    {
        return response()->json([
            'initial_data'  => $data,
            'error_message' => $message,
        ], 404);
    }

    /**
     * @param object $data
     * @param string $message
     *
     * @return JsonResponse
     */
    public static function badRequest(object $data, string $message = 'Bad Request')
    {
        return response()->json([
            'initial_data'  => $data,
            'error_message' => $message,
        ], 400);
    }

    /**
     * @param object $data
     * @param string $message
     *
     * @return JsonResponse
     */
    public static function unAuthorized(object $data, string $message = 'Unauthorized')
    {
        return response()->json([
            'initial_data'  => $data,
            'error_message' => $message,
        ], 401);
    }

    /**
     * @param string $token
     * @param string $message
     *
     * @return JsonResponse
     */
    public static function successWithToken(string $token, string $message = 'success')
    {
        return response()->json([
            'data'    => [
                'access_token' => $token,
                'token_type'   => 'bearer',
                'expires_in'   => auth()->factory()->getTTL() * 60
            ],
            'message' => $message,
        ], 200);
    }
}
