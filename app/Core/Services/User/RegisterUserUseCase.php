<?php

namespace App\Core\Services\User;

use App\Core\Dto\User\RegisterUserDto;
use App\Core\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;

class RegisterUserUseCase
{
    /**
     * @param RegisterUserDto $dto
     *
     * @return JsonResponse
     */
    public function register(RegisterUserDto $dto)
    {
        return (new UserRepository)->register($dto);
    }
}
