<?php


namespace App\Core\Services\User;

use App\Core\Dto\User\RegisterUserDto;
use App\Core\Repositories\UserRepository;

class LoginUserUseCase
{
    public function login(RegisterUserDto $dto)
    {
        return (new UserRepository)->login($dto);
    }
}
