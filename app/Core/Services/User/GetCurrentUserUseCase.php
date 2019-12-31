<?php

namespace App\Core\Services\User;

use Illuminate\Contracts\Auth\Authenticatable;

class getCurrentUserUseCase extends UserUseCase
{
    /**
     * @return Authenticatable
     */
    public function execute()
    {
        return $this->repo->getCurrentUser();
    }
}
