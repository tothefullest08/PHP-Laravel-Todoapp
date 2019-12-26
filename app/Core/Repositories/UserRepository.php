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

    // /**
    //  * @param LoginAuthDto $dto
    //  *
    //  * @return JsonResponse
    //  */
    // public function login(LoginAuthDto $dto)
    // {
    //     $token = auth()->attempt([
    //         'email' => $dto->getEmail(),
    //         'password' => $dto->getPassword()
    //     ]);
    //
    //     if (!$token) {
    //         return ResponseHandler::unAuthorized($dto);
    //     }
    //     return ResponseHandler::successWithToken($token);
    // }

    /**
     * @return JsonResponse
     */
    public function getCurrentUser()
    {
        return ResponseHandler::success(auth()->user());
    }

    // /**
    //  * @return JsonResponse
    //  */
    // public function logout()
    // {
    //     $user = auth()->user();
    //     try {
    //         auth()->logout();
    //         return ResponseHandler::success($user);
    //     } catch (QueryException $e) {
    //         return ResponseHandler::badRequest($user, 'Database error');
    //     }
    // }
}
