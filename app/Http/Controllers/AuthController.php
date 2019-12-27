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
     * @param LoginAuthUseCase $useCase
     *
     * @return JsonResponse
     */
    public function login(Request $request, LoginAuthUseCase $useCase): JsonResponse
    {
        $dto             = (new LoginAuthDto)->setEmail($request->input('email'))->setPassword($request->input('password'));
        $useCaseResponse = $useCase->execute($dto);

        return $useCaseResponse;
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @param LogoutAuthUseCase $useCase
     *
     * @return JsonResponse
     */
    public function logout(LogoutAuthUseCase $useCase): JsonResponse
    {
        return $useCase->execute();
    }
}
