<?php

namespace App\Core\Services\Auth;

use App\Core\Repositories\AuthRepository;
use Illuminate\Http\JsonResponse;

class LogoutAuthUseCase
{
    /**
     * @return JsonResponse
     */
    public function logout()
    {
        return (new AuthRepository)->logout();
    }
}
