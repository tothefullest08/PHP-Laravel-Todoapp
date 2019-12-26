<?php

namespace App\Http\Controllers;

use App\Core\Dto\User\RegisterUserDto;
use App\Core\Services\User\RegisterUserUseCase;
use App\Core\Services\User\LoginUserUseCase;
use App\Core\Services\User\GetCurrentUserUseCase;
use App\Core\Services\User\LogoutUserUseCase;
use App\Http\Requests\RegisterUserRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @param RegisterUserRequest $request
     *
     * @return JsonResponse
     */
    public function register(RegisterUserRequest $request): JsonResponse
    {
        $dto = new RegisterUserDto($request->getEmail(), $request->getPassword());
        $useCaseResponse = (new RegisterUserUseCase)->register($dto);

        return $useCaseResponse;
    }

    /**
     * Get a JWT via given credentials
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $dto = new RegisterUserDto($request->input('email'), $request->input('password'));
        $useCaseResponse = (new LoginUserUseCase)->login($dto);

        return $useCaseResponse;
    }

    /**
     * Get the authenticated User
     *
     * @return JsonResponse
     */
    public function getCurrentUser(): JsonResponse
    {
        return (new GetCurrentUserUseCase)->get();
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        return (new LogoutUserUseCase)->logout();
    }
}
