<?php

namespace App\Core\Services\User;

use App\Core\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;

class LogoutUserUseCase
{
    /**
     * @return JsonResponse
     */
    public function logout()
    {
        return (new UserRepository)->logout();
    }
}
