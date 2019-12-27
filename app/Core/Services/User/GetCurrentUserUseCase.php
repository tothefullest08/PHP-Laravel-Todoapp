<?php

namespace App\Core\Services\User;

use Illuminate\Http\JsonResponse;

class getCurrentUserUseCase extends UserUseCase
{
    /**
     * @return JsonResponse
     */
    public function execute()
    {
        return $this->repo->getCurrentUser();
    }
}
