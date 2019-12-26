<?php

namespace App\Http\Responses;

class ResponseHandler
{
    public static function success($data, $message='success', $statusCode = 200)
    {
        return response()->json([
            'data' => $data,
            'message' => $message,
        ], $statusCode);
    }

    public static function notFound($data, $message='Not Found')
    {
        return response()->json([
            'initial_data' => $data,
            'error_message' => $message,
        ], 404);
    }

    public static function badRequest($data, $message='Bad Request')
    {
        return response()->json([
            'initial_data' => $data,
            'error_message' => $message,
        ], 400);
    }

    public static function unAuthorized($data, $message='Unauthorized')
    {
        return response()->json([
            'initial_data' => $data,
            'error_message' => $message,
        ], 401);
    }

    public static function successWithToken($token, $message='success')
    {
        return response()->json([
            'data' => [
                'access_token' => $token,
                'token_type'   => 'bearer',
                'expires_in'   => auth()->factory()->getTTL() * 60
            ],
            'message' => $message,
        ], 200);
    }
}
