<?php

namespace App\Core\Repositories;

use App\Core\Dto\Auth\LoginAuthDto;
use App\Http\Responses\ResponseHandler;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;

class AuthRepository
{
    /**
     * @param LoginAuthDto $dto
     *
     * @return JsonResponse
     */
    public function login(LoginAuthDto $dto)
    {
        $token = auth()->attempt([
            'email' => $dto->getEmail(),
            'password' => $dto->getPassword()
        ]);

        if (!$token) {
            return ResponseHandler::unAuthorized($dto);
        }
        return ResponseHandler::successWithToken($token);
    }

    /**
     * @return JsonResponse
     */
    public function logout()
    {
        $user = auth()->user();
        try {
            auth()->logout();
            return ResponseHandler::success($user);
        } catch (QueryException $e) {
            return ResponseHandler::badRequest($user, 'Database error');
        }
    }
}
