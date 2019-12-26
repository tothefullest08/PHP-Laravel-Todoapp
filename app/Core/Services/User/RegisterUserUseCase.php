<?php

namespace App\Core\Services\User;

use App\Core\Dto\User\RegisterUserDto;
use App\Core\Repositories\UserRepository;

class RegisterUserUseCase
{
    public function register(RegisterUserDto $dto)
    {
        return (new UserRepository)->register($dto);
    }
}
