<?php

namespace App\Core\Services\User;

use App\Core\Dto\User\RegisterUserDto;

class RegisterUserUseCase extends UserUseCase
{
    /**
     * @param RegisterUserDto $dto
     *
     * @return \App\Core\Entities\User
     */
    public function execute(RegisterUserDto $dto)
    {
        return $this->repo->register($dto);
    }
}
