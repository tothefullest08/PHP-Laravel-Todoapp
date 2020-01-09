<?php

namespace App\Core\Services\Auth;

use Illuminate\Contracts\Auth\Authenticatable;

class LogoutAuthUseCase extends AuthUseCase
{
    /**
     * @return Authenticatable
     */
    public function execute()
    {
        return $this->repo->logout();
    }
}
