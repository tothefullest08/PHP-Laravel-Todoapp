<?php

namespace App\Core\Services\Auth;

use App\Core\Dto\Auth\LoginAuthDto;
use Illuminate\Http\JsonResponse;

class LoginAuthUseCase extends AuthUseCase
{
    /**
     * @param LoginAuthDto $dto
     *
     * @return JsonResponse
     */
    public function execute(LoginAuthDto $dto)
    {
        return $this->repo->login($dto);
    }
}
