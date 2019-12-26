<?php

namespace App\Core\Services\User;

use App\Core\Repositories\UserRepository;

class LogoutUserUseCase
{
    public function logout()
    {
        return (new UserRepository)->logout();
    }
}
