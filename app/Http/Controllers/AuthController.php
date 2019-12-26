<?php

namespace App\Http\Controllers;

use App\Core\Dto\Auth\LoginAuthDto;
use App\Core\Services\Auth\LoginAuthUseCase;
use App\Core\Services\Auth\LogoutAuthUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * AuthController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth.jwt', ['except' => ['login']]);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $dto             = new LoginAuthDto($request->input('email'), $request->input('password'));
        $useCaseResponse = (new LoginAuthUseCase)->login($dto);

        return $useCaseResponse;
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        return (new LogoutAuthUseCase)->logout();
    }
}
