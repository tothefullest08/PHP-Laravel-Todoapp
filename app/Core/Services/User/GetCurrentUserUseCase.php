<?php

namespace App\Core\Services\User;

use App\Core\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;

class getCurrentUserUseCase
{
    /**
     * @return JsonResponse
     */
    public function get()
    {
        return (new UserRepository)->getCurrentUser();
    }
}
