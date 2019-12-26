<?php

namespace App\Http\Controllers;

use App\Core\Dto\User\RegisterUserDto;
use App\Core\Services\User\RegisterUserUseCase;
use App\Core\Services\User\GetCurrentUserUseCase;
use App\Http\Requests\RegisterUserRequest;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.jwt', ['except' => ['register']]);
    }

    /**
     * @param RegisterUserRequest $request
     *
     * @return JsonResponse
     */
    public function register(RegisterUserRequest $request): JsonResponse
    {
        $dto             = new RegisterUserDto($request->getEmail(), $request->getPassword());
        $useCaseResponse = (new RegisterUserUseCase)->register($dto);

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
}
