<?php

namespace App\Core\Repositories;

use App\User;
use App\Core\Dto\User\RegisterUserDto;
use App\Http\Responses\ResponseHandler;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;

class UserRepository
{
    /**
     * @param RegisterUserDto $dto
     *
     * @return JsonResponse
     */
    public function register(RegisterUserDto $dto)
    {
        $user = new User;
        $user->email = $dto->getEmail();
        $user->password = $dto->getPassword();

        try {
            $user->save();
            return ResponseHandler::success($user, 'create success', 201);
        } catch (QueryException $e) {
            return ResponseHandler::badRequest($dto, 'Database error');
        }
    }

    /**
     * @return JsonResponse
     */
    public function getCurrentUser()
    {
        return ResponseHandler::success(auth()->user());
    }
}
