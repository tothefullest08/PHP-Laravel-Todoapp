<?php

namespace App\Core\Services\User;

use App\Core\Dto\User\RegisterUserDto;
use App\User;

class RegisterUserUseCase extends UserUseCase
{
    /**
     * @param RegisterUserDto $dto
     *
     * @return User
     */
    public function execute(RegisterUserDto $dto)
    {
        return $this->repo->register($dto);
    }
}
