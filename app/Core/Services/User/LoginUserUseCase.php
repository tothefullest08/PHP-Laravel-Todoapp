<?php


namespace App\Core\Services\User;

use App\Core\Dto\User\RegisterUserDto;
use App\Core\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;

class LoginUserUseCase
{
    /**
     * @param RegisterUserDto $dto
     *
     * @return JsonResponse
     */
    public function login(RegisterUserDto $dto)
    {
        return (new UserRepository)->login($dto);
    }
}
