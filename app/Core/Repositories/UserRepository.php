<?php

namespace App\Core\Repositories;

use App\User;
use App\Core\Dto\User\RegisterUserDto;
use Illuminate\Contracts\Auth\Authenticatable;

class UserRepository
{
    /**
     * @param RegisterUserDto $dto
     *
     * @return \App\Core\Entities\User
     */
    public function register(RegisterUserDto $dto)
    {
        $user           = new User;
        $user->email    = $dto->getEmail();
        $user->password = $dto->getPassword();

        $user->save();
        return $user->toEntity();
    }

    /**
     * @return Authenticatable
     */
    public function getCurrentUser()
    {
        return auth()->user()->toEntity();
    }
}
