<?php

namespace App\Http\Controllers;

use App\Core\Dto\User\RegisterUserDto;
use App\Core\Services\User\RegisterUserUseCase;
use App\Core\Services\User\GetCurrentUserUseCase;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Responses\ResponseHandler;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * UserController constructor.
     */
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
        $dto = (new RegisterUserDto)
            ->setEmail($request->input('email'))
            ->setPassword(bcrypt($request->input('password')));

        try {
            $useCaseResponse = $useCase->execute($dto);
        } catch (QueryException $e) {
            return ResponseHandler::badRequest($dto, 'Database error');
        }

        return ResponseHandler::success($useCaseResponse, 'register success', 201);
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
        $useCaseResponse = $useCase->execute();

        return ResponseHandler::success($useCaseResponse);
    }
}
