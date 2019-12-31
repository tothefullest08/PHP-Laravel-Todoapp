<?php

namespace App\Core\Repositories;

use App\Core\Dto\Auth\LoginAuthDto;
use Illuminate\Contracts\Auth\Authenticatable;

class AuthRepository
{
    /**
     * @param LoginAuthDto $dto
     *
     * @return mixed|null
     */
    public function login(LoginAuthDto $dto)
    {
        $token = auth()->attempt([
            'email'    => $dto->getEmail(),
            'password' => $dto->getPassword()
        ]);

        if (!$token) {
            return null;
        }
        return $token;
    }

    /**
     * @return Authenticatable
     */
    public function logout()
    {
        $user = auth()->user();
        auth()->logout();

        return $user;
    }
}
