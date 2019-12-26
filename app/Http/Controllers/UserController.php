<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Http\Responses\CreateSuccessResponse;
use App\Http\Responses\SuccessResponse;
use App\Http\Responses\UnauthorizedResponse;
use App\User;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * @param RegisterUserRequest $request
     *
     * @return JsonResponse
     */
    public function register(RegisterUserRequest $request): JsonResponse
    {
        $user           = new User;
        $user->email    = $request->getEmail();
        $user->password = $request->getPassword();
        $user->save();

        return (new CreateSuccessResponse($user))->getResult();
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
            return (new UnauthorizedResponse)->getResult();
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
        return (new SuccessResponse(auth()->user()))->getResult();
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

        return (new SuccessResponse($user))->getResult();
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
}
