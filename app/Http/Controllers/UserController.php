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
     * @param RegisterUserUseCase $useCase
     *
     * @return JsonResponse
     */
    public function register(RegisterUserRequest $request, RegisterUserUseCase $useCase): JsonResponse
    {
        $dto             = (new RegisterUserDto)->setEmail($request->getEmail())->setPassword($request->getPassword());
        $useCaseResponse = $useCase->execute($dto);

        return $useCaseResponse;
    }

    /**
     * Get the authenticated User
     *
     * @param GetCurrentUserUseCase $useCase
     *
     * @return JsonResponse
     */
    public function getCurrentUser(GetCurrentUserUseCase $useCase): JsonResponse
    {
        return $useCase->execute();
    }
}
