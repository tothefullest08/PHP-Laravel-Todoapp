<?php

namespace App\Core\Services\Auth;

use Illuminate\Http\JsonResponse;

class LogoutAuthUseCase extends AuthUseCase
{
    /**
     * @return JsonResponse
     */
    public function execute()
    {
        return $this->repo->logout();
    }
}
