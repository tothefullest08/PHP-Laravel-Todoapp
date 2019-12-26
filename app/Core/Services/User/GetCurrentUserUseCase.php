<?php

namespace App\Core\Services\User;

use App\Core\Repositories\UserRepository;

class getCurrentUserUseCase
{
    public function get()
    {
        return (new UserRepository)->getCurrentUser();
    }
}
