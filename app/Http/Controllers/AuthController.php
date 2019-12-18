<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        $validator = $this->validateRequestForRegistration($request->all());

        if ($validator->fails()) {
            return $this->validateBadResponseForRegistration($validator);
        }

        $user           = new User;
        $user->email    = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        return $this->respondWithSuccess('register', 201, $user);
    }

    /**
     * Get a JWT via given credentials
     *
     * @return JsonResponse
     */
    public function login(): JsonResponse
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return $this->respondWithError('Unauthorized.', 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User
     *
     * @return JsonResponse
     */
    public function user(): JsonResponse
    {
        return $this->respondWithSuccess('Current user access', 200, auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        $user = auth()->user();
        auth()->logout();

        return $this->respondWithSuccess('Log Out', 200, $user);
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return JsonResponse
     */
    protected function respondWithToken($token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth()->factory()->getTTL() * 60
        ]);
    }

    /**
     * return result for validation of user registration
     *
     * @param array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator|Validator
     */
    private function validateRequestForRegistration(array $data)
    {
        return Validator::make($data, [
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|max:10'
        ]);
    }

    /**
     * return 400 error response when input data validation failed.
     *
     * @param mixed $validator
     *
     * @return JsonResponse
     */
    private function validateBadResponseForRegistration($validator): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $validator->messages()
        ], 400);
    }

    /**
     * return adequate Http Status code success
     *
     * @param string $message
     * @param int $status
     * @param object $data
     *
     * @return JsonResponse
     */
    private function respondWithSuccess(string $message, int $status, object $data): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message . ' succeed',
            'data'    => $data->toArray()
        ], $status);
    }

    /**
     * return adequate Http Status code for error
     *
     * @param string $message
     * @param int $status
     *
     * @return JsonResponse
     */
    private function respondWithError(string $message, int $status): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message . ' failed',
        ], $status);
    }
}
