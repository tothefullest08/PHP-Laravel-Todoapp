<?php

namespace App\Core\Repositories;

use App\User;
use App\Core\Dto\User\RegisterUserDto;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\QueryException;

class UserRepository
{
    /**
     * @param RegisterUserDto $dto
     *
     * @return User
     */
    public function register(RegisterUserDto $dto)
    {
        $user           = new User;
        $user->email    = $dto->getEmail();
        $user->password = $dto->getPassword();

        try {
            $user->save();
            return $user;
        } catch (QueryException $e) {
            throw new QueryException;
        }
    }

    /**
     * @return Authenticatable
     */
    public function getCurrentUser()
    {
        return auth()->user();
    }
}
